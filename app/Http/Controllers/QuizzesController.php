<?php

namespace App\Http\Controllers;

use App\Models\Quizzes;
use App\Models\Lessons;
use App\Models\LOs;
use App\Models\Topics;
use Illuminate\Http\Request;
use DataTables;
use App\Traits\SummernoteWithUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class QuizzesController extends Controller
{
    use SummernoteWithUpload;
    public function index(Request $request, $id_topic)
    {
        if ($request->ajax()) {
            $data = Quizzes::where("id_topic", "=", $id_topic)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $id_topic = $data->id_topic;
                    $button = '<a href="' . route('quiz.duplicate', [$id_topic,$data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-success btn-sm">Duplicate</a>';;
                    $button .= '&nbsp;&nbsp;&nbsp;<a href="' . route('quiz.update', [$id_topic,$data->id]) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Edit</a>';;
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('quiz.delete', [$id_topic,$data->id]) . '" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"' . "onclick='return'" . '>Delete</a>';
                    return $button;
                })
                ->addColumn('question', function ($data) {
                    return htmlspecialchars_decode(htmlspecialchars($data->question));
                })
                ->rawColumns(['action','question'])
                ->make(true);
        }

        return view('pages.quiz.quiz', compact('id_topic'));
    }

    public function create_view($id_topic)
    {
        return view('pages.quiz.create', compact('id_topic'));
    }

    public function create_process(Request $request, $id_topic)
    {
        $request->validate([
            'editor1' => 'required',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
            'answer_4' => 'required',
            'key' => 'required',
            'explanation' => 'required',
            'type' => 'required',
        ]);

        $quiz = new Quizzes();
        $quiz->id_topic = $id_topic;
        $quiz->question = htmlspecialchars_decode($this->summernote($request['editor1']));
        $quiz->answer_1 = $request->answer_1;
        $quiz->answer_2 = $request->answer_2;
        $quiz->answer_3 = $request->answer_3;
        $quiz->answer_4 = $request->answer_4;
        $quiz->key = $request->key;
        $quiz->type = $request->type;
        $quiz->explanation = $request->explanation;
        $quiz->save();

        return redirect()->route('quiz', [$id_topic])->withSuccess('Quiz created successfully.');
    }

    public function update_view($id_topic,$id_quiz)
    {
        $data = Quizzes::find($id_quiz);
        return view('pages.quiz.update', compact('data','id_topic'));
    }

    public function update_process(Request $request, $id_topic,$id_quiz)
    {
        $request->validate([
            'editor1' => 'required',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
            'answer_4' => 'required',
            'key' => 'required',
            'explanation' => 'required',
            'type' => 'required',
        ]);

        $quiz = Quizzes::find($id_quiz);
        $quiz->question = htmlspecialchars_decode($this->summernote($request['editor1']));
        $quiz->answer_1 = $request->answer_1;
        $quiz->answer_2 = $request->answer_2;
        $quiz->answer_3 = $request->answer_3;
        $quiz->answer_4 = $request->answer_4;
        $quiz->key = $request->key;
        $quiz->explanation = $request->explanation;
        $quiz->type = $request->type;
        $quiz->save();

        return redirect()->route('quiz', [$id_topic])->withSuccess('Quiz updated successfully.');
    }

    public function duplicate(Request $request, $id_topic,$id_quiz)
    {
        $quiz_old = Quizzes::find($id_quiz);

        $quiz = new Quizzes();
        $quiz->id_topic = $quiz_old->id_topic;
        $quiz->question = $quiz_old->question;
        $quiz->answer_1 = $quiz_old->answer_1;
        $quiz->answer_2 = $quiz_old->answer_2;
        $quiz->answer_3 = $quiz_old->answer_3;
        $quiz->answer_4 = $quiz_old->answer_4;
        $quiz->key = $quiz_old->key;
        $quiz->explanation = $quiz_old->explanation;
        if($quiz_old->type == "pre_test") {
            $quiz->type = "post_test";
        } else {
            $quiz->type = "pre_test";
        }
        $quiz->save();

        return redirect()->route('quiz', [$id_topic])->withSuccess('Quiz duplicated successfully.');
    }

    public function delete($id_topic,$id_quiz)
    {
        $quiz = Quizzes::find($id_quiz);
        $quiz->delete();

        return redirect()->route('quiz', [$id_topic])->withSuccess('Quiz deleted successfully.');
    }
}
