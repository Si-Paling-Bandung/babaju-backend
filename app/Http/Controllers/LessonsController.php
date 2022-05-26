<?php

namespace App\Http\Controllers;

use App\Models\Lessons;
use App\Models\LOs;
use App\Models\Topics;
use Illuminate\Http\Request;
use DataTables;
use App\Traits\SummernoteWithUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LessonsController extends Controller
{
    use SummernoteWithUpload;
    public function index(Request $request, $id_topic, $id_lo)
    {
        // Check Topic
        $topic = Topics::find($id_topic);
        if (is_null($topic)) {
            return redirect()->to('topic')->withErrors("Topic not correct, please dont change from url");
        }

        // Check LO
        $lo = LOs::find($id_lo);
        if (is_null($lo)) {
            return redirect()->route('lo', compact('id_topic'))->withErrors("LO not correct, please dont change from url");
        }

        // Check LO is Topic Child
        if ($lo->id_topic != $id_topic) {
            return redirect()->back()->withErrors("LO is not Topic child, please dont change from url");
        }

        if ($request->ajax()) {
            $data = Lessons::where("id_lo", "=", $id_lo)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $id_topic = LOs::find($data->id_lo)->id_topic;
                    $button = '<a href="' . route('lesson.update', [$id_topic, $data->id_lo, $data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('lesson.delete', [$id_topic, $data->id_lo, $data->id]) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.lesson.lesson', compact('topic', 'lo'));
    }

    public function create_text($id_topic, $id_lo)
    {
        return view('pages.lesson.createText', compact('id_topic', 'id_lo'));
    }

    public function create_video($id_topic, $id_lo)
    {
        return view('pages.lesson.createVideo', compact('id_topic', 'id_lo'));
    }

    public function create_process(Request $request, $id_topic, $id_lo)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $lesson = new Lessons();
        $lesson->id_lo = $id_lo;
        $lesson->name = $request->name;

        // Text
        if (isset($request->editor1)) {
            $lesson->lesson_text = htmlspecialchars_decode($this->summernote($request['editor1']));
            if (isset($request->attachment)) {
                $lesson->lesson_attachment = Storage::disk('public')->put('lesson', $request->file('attachment'));
            }
        }
        // Video
        elseif (isset($request->video_url)) {
            $lesson->video_url = $request->video_url;
            $lesson->video_duration = $request->video_duration;
        }

        $lesson->save();

        return redirect()->route('lesson', [$id_topic, $id_lo])->withSuccess('Lesson created successfully.');
    }

    public function update_view($id_topic, $id_lo, $id_lesson)
    {
        $data = Lessons::find($id_lesson);
        if(isset($data->lesson_attachment)){
            $name = explode("lesson/", $data->lesson_attachment)[1];
        } else {
            $name = "None";
        }

        return view('pages.lesson.update', compact('id_topic', 'id_lo', 'data','name'));
    }

    public function update_process(Request $request, $id_topic, $id_lo, $id_lesson)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $lesson = Lessons::find($id_lesson);
        $lesson->name = $request->name;

        // Text
        if (isset($request->editor1)) {
            $lesson->lesson_text = htmlspecialchars_decode($this->summernote($request['editor1']));
            if (isset($request->attachment)) {
                $image_path = 'storage/' . $lesson->lesson_attachment;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $lesson->lesson_attachment = Storage::disk('public')->put('lesson', $request->file('attachment'));
            }
        }
        // Video
        elseif (isset($request->video_url)) {
            $lesson->video_url = $request->video_url;
            $lesson->video_duration = $request->video_duration;
        }

        $lesson->save();

        return redirect()->route('lesson', [$id_topic, $id_lo])->withSuccess('Lesson updated successfully.');
    }

    public function delete($id_topic, $id_lo, $id_lesson)
    {
        $data = Lessons::find($id_lesson);
        $data->delete();

        return redirect()->route('lesson', [$id_topic, $id_lo])->withSuccess('Lesson deleted successfully.');
    }
}
