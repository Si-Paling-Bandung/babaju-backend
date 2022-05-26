<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Feedback;
use App\Models\Rating;
use App\Models\Topics;
use App\Models\UserTask;
use App\Models\Task;
use App\Models\UserCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Traits\SummernoteWithUpload;

class TopicsController extends Controller
{
    use SummernoteWithUpload;
    public function index()
    {
        $data = Topics::latest()->get();
        return view('pages.topic.topic', compact('data'));
    }

    public function create_view()
    {
        return view('pages.topic.create');
    }

    public function create_process(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'foto' => ['required', 'mimes:jpg,jpeg,png'],
        ]);

        $topic = new Topics();

        $topic->title = $request->title;
        $topic->author = $request->author;
        $topic->short_description = $request->short_description;
        $topic->description = $request->description;
        $topic->cover_image = Storage::disk('public')->put('topics', $request->file('foto'));

        $topic->save();

        $task = new Task();
        $task->id_topic = $topic->id;
        $task->title = "Belum Ada Title";
        $task->text = "Belum Ada Text";
        $task->save();

        return redirect()->route('topic')->withSuccess('Topic created successfully.');
    }

    public function update_view($id)
    {

        $data = Topics::find($id);
        return view('pages.topic.update', compact('data'));
    }

    public function update_process(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'foto' => 'mimes:jpg,jpeg,png',
        ]);

        $topic = Topics::find($id);
        $topic->title = $request->title;
        $topic->author = $request->author;
        $topic->description = $request->description;
        $topic->short_description = $request->short_description;

        if (isset($request->foto)) {
            $image_path = 'storage/' . $topic->cover_image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            $topic->cover_image = Storage::disk('public')->put('topics', $request->file('foto'));
        }

        $topic->save();

        return redirect()->route('topic')->withSuccess('Topic updated successfully.');
    }

    public function delete($id)
    {
        $topic = Topics::find($id);
        $topic->delete();

        return redirect()->route('topic')->withSuccess('Product deleted successfully.');
    }

    // Feedback

    public function feedback(Request $request, $id_topic)
    {
        $feedback = Feedback::where('id_topic', '=', $id_topic)->get();
        if (is_null($feedback)) {
            return redirect()->to('topic')->withErrors("No Feedback Found !");
        }

        if ($request->ajax()) {
            $data = Feedback::where('id_topic', '=', $id_topic)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rating', function ($data) {
                    $rating = Rating::where('id_user', '=', Auth::user()->id)->where('id_topic', '=', $data->id)->first();
                    if ($rating) {
                        return $rating->rating;
                    } else {
                        return "Belum Ada";
                    }
                })
                ->rawColumns(['rating'])
                ->make(true);
        }

        $id = $id_topic;
        return view('pages.topic.feedback', compact('id'));
    }

    // Exercise
    public function exercise(Request $request, $id_topic)
    {
        $userTask = UserTask::where('id_topic', '=', $id_topic)->get();
        if (is_null($userTask)) {
            return redirect()->to('topic')->withErrors("No Exercises Found !");
        }

        if ($request->ajax()) {
            $data = $userTask;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $id_topic = $data->id_topic;
                    $button = '<a href="' . route('exercise.grade', [$id_topic, $data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Grade</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $id = $id_topic;

        $task = Task::where('id_topic', $id_topic)->first();
        if (is_null($task)) {
            $title = "Belum Ada Title";
            $text = "Belum Ada Text";
        } else {
            $title = $task->title;
            $text = $task->text;
        }


        return view('pages.exercise.exercise', compact('id', 'title', 'text'));
    }

    public function exercise_create_view($id_topic)
    {
        $task = Task::where('id_topic', $id_topic)->first();
        if (is_null($task)) {
            $title = "Belum Ada Title";
            $text = "Belum Ada Text";
        } else {
            $title = $task->title;
            $text = $task->text;
        }
        return view('pages.exercise.update', compact('id_topic', 'title', 'text'));
    }

    public function exercis_create_process(Request $request, $id_topic)
    {
        $request->validate([
            'name' => 'required',
            'editor1' => 'required'
        ]);

        $task = Task::where('id_topic', $id_topic)->first();
        if (is_null($task)) {
            $task = new Task();
            $task->id_topic = $id_topic;
            $task->title = $request->name;
            $task->text = htmlspecialchars_decode($this->summernote($request['editor1']));
            $task->save();

            return redirect()->route('exercise', $id_topic)->withSuccess('Exercise updated successfully.');
        } else {
            $task->title = $request->name;
            $task->text = htmlspecialchars_decode($this->summernote($request['editor1']));
            $task->save();

            return redirect()->route('exercise', $id_topic)->withSuccess('Exercise updated successfully.');
        }
    }

    public function exercise_grade_view($id_topic, $id_task)
    {
        $userTask = UserTask::find($id_task);
        return view('pages.exercise.grade', compact('userTask', 'id_topic'));
    }

    public function exercise_grade_process(Request $request, $id_topic, $id_task)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'notes' => 'required'
        ]);
        $userTask = UserTask::find($id_task);
        $userTask->grade = $request->grade;
        $userTask->teacher_notes = $request->notes;
        $userTask->save();
        return redirect()->route('exercise', $id_topic)->withSuccess('User Task graded successfully.');
    }

    // Exercise
    public function certificate(Request $request, $id_topic)
    {
        $userCertificate = UserCertificate::where('id_topic', '=', $id_topic)->get();
        if (is_null($userCertificate)) {
            return redirect()->to('topic')->withErrors("No Certificates Found !");
        }

        if ($request->ajax()) {
            $data = $userCertificate;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $id_topic = $data->id_topic;
                    $button = '<a href="' . route('exercise.grade', [$id_topic, $data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Grade</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $id = $id_topic;

        $certificate = Certificate::where('id_topic', $id_topic)->first();
        if (is_null($certificate)) {
            $number = "Belum Ada Number";
            $file = "Belum Ada File";
        } else {
            $number = $certificate->number;
            $file = $certificate->file;
        }


        return view('pages.certificate.certificate', compact('id', 'number', 'file'));
    }
}
