<?php

namespace App\Http\Controllers;

use App\Models\GradeQuiz;
use App\Models\Histories;
use App\Models\Topics;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Grade;
use App\Models\Instance;
use App\Models\LocalOfficial;
use App\Models\Quizzes;
use Illuminate\Support\Facades\Auth;
use Response;

class GradeQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $topic = Topics::all();
        if (Auth::user()->role == 'admin') {
            $user = User::paginate(10);
        } else {
            $user = User::where('id_instansi', '=', Auth::user()->id_instansi)->paginate(10);
        }

        foreach ($user as $us) {
            if (!isset($us->id_instansi) && !isset($us->id_local_official)) {
                $us->{'asal'} = "Lainnya";
            } elseif (isset($us->id_instansi) && !isset($us->id_local_official)) {
                $instance = Instance::find($us->id_instansi);
                $us->{'asal'} = $instance->title;
            } elseif (!isset($us->id_instansi) && isset($us->id_local_official)) {
                $local = LocalOfficial::find($us->id_local_official);
                $us->{'asal'} = $local->title;
            }
            $pre_test = [];
            $post_test = [];
            $status = [];
            foreach ($topic as $tp) {
                $check_pre_test = Grade::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'pre_test')->first();
                if ($check_pre_test) {
                    array_push($pre_test, $check_pre_test->grade);
                } else {
                    array_push($pre_test, "Belum Mengerjakan");
                }
                $check_post_test = Grade::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'post_test')->first();
                if ($check_post_test) {
                    array_push($post_test, $check_post_test->grade);
                } else {
                    array_push($post_test, "Belum Mengerjakan");
                }
                $check_status = Histories::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->first();
                if ($check_status) {
                    array_push($status, $check_status->status);
                } else {
                    array_push($status, "Belum Selesai");
                }
            }
            $us->{'pre_test'} = $pre_test;
            $us->{'post_test'} = $post_test;
            $us->{'status'} = $status;
        }

        return view('pages.grade.grade', compact('topic', 'user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        $topic = Topics::all();
        if (Auth::user()->role == 'admin') {
            $user = User::all();
        } else {
            $user = User::where('id_instansi', '=', Auth::user()->id_instansi)->get();
        }

        foreach ($user as $us) {
            if (!isset($us->id_instansi) && !isset($us->id_local_official)) {
                $us->{'asal'} = "Lainnya";
            } elseif (isset($us->id_instansi) && !isset($us->id_local_official)) {
                $instance = Instance::find($us->id_instansi);
                $us->{'asal'} = $instance->title;
            } elseif (!isset($us->id_instansi) && isset($us->id_local_official)) {
                $local = LocalOfficial::find($us->id_local_official);
                $us->{'asal'} = $local->title;
            }
            $pre_test = [];
            $post_test = [];
            $status = [];
            foreach ($topic as $tp) {
                $check_pre_test = Grade::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'pre_test')->first();
                if ($check_pre_test) {
                    array_push($pre_test, $check_pre_test->grade);
                } else {
                    array_push($pre_test, "Belum Mengerjakan");
                }
                $check_post_test = Grade::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'post_test')->first();
                if ($check_post_test) {
                    array_push($post_test, $check_post_test->grade);
                } else {
                    array_push($post_test, "Belum Mengerjakan");
                }
                $check_status = Histories::where('id_user', '=', $us->id)->where('id_topic', '=', $tp->id)->first();
                if ($check_status) {
                    array_push($status, $check_status->status);
                } else {
                    array_push($status, "Belum Selesai");
                }
            }
            $us->{'pre_test'} = $pre_test;
            $us->{'post_test'} = $post_test;
            $us->{'status'} = $status;
        }

        return view('pages.grade.generate', compact('topic', 'user'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexDetail(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->role == 'admin') {
                $data = User::all();
            } else {
                $data = User::where('id_instansi', '=', Auth::user()->id_instansi)->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('instance', function ($data) {
                    if (!isset($data->id_instansi) && !isset($data->id_local_official)) {
                        return "Lainnya";
                    } elseif (isset($data->id_instansi) && !isset($data->id_local_official)) {
                        $instance = Instance::find($data->id_instansi);
                        return $instance->title;
                    } elseif (!isset($data->id_instansi) && isset($data->id_local_official)) {
                        $local = LocalOfficial::find($data->id_local_official);
                        return $local->title;
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('detail.grade.show', $data->id) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Detail</a>';
                })
                ->rawColumns(['instance', 'action'])
                ->make(true);
        }

        return view('pages.grade.detail');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GradeQuiz  $gradeQuiz
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id_user)
    {
        $topic = Topics::all();
        $user = User::find($id_user);
        foreach ($topic as $tp) {
            $check_pre_test = Grade::where('id_user', '=', $user->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'pre_test')->first();
            if ($check_pre_test) {
                $tp->{'pre_test'} = $check_pre_test->grade;
            } else {
                $tp->{'pre_test'} = "Belum Mengerjakan";
            }
            $check_post_test = Grade::where('id_user', '=', $user->id)->where('id_topic', '=', $tp->id)->where('type', '=', 'post_test')->first();
            if ($check_post_test) {
                $tp->{'post_test'} = $check_post_test->grade;
            } else {
                $tp->{'post_test'} = "Belum Mengerjakan";
            }
            $check_status = Histories::where('id_user', '=', $user->id)->where('id_topic', '=', $tp->id)->first();
            if ($check_status) {
                $tp->{'status'} = $check_status->status;
            } else {
                $tp->{'status'} = "Belum Selesai";
            }
            $tp->{'user_id'} = $user->id;
        }

        if ($request->ajax()) {
            $data = $topic;
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->title;
                })
                ->addColumn('status', function ($data) {
                    return $data->status;
                })
                ->addColumn('pre-test', function ($data) {
                    return $data->pre_test;
                })
                ->addColumn('post-test', function ($data) {
                    return $data->post_test;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="' . route('detail.grade.show.quiz', [$data->user_id, $data->id, 'pre_test']) . '" type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Pre-Test</a>';
                    $button .= '&nbsp;&nbsp;&nbsp;<a data-toggle="confirmation" data-singleton="true" data-popout="true" href="' . route('detail.grade.show.quiz', [$data->user_id, $data->id, 'post_test']) . '" type="button" name="delete" id="' . $data->id . '" class="edit btn btn-primary btn-sm">Post-Test</a>';
                    return $button;
                })
                ->rawColumns(['name', 'status', 'pre-test', 'post-test', 'action'])
                ->make(true);
        }

        return view('pages.grade.show', compact('user','topic'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GradeQuiz  $gradeQuiz
     * @return \Illuminate\Http\Response
     */
    public function quiz(Request $request, $id_user, $id_topic, $section)
    {
        $question = Quizzes::where('id_topic', '=', $id_topic)->where('type', '=', $section)->get();
        foreach ($question as $qs) {
            $user_answer = GradeQuiz::where('id_quiz', '=', $qs->id)->where('id_user', '=', $id_user)->first();
            if ($user_answer) {
                $qs->{"is_right"} = $user_answer->is_right;
                $qs->{"user_answer"} = $user_answer->user_answer;
            }
        }

        $grade = Grade::where('id_user', '=', $id_user)->where('id_topic', '=', $id_topic)->where('type', '=', $section)->first();
        $user = User::find($id_user);
        $topic = Topics::find($id_topic);

        return view('pages.grade.quiz', compact('question', 'grade', 'id_user', 'id_topic', 'section','user','topic'));
    }

    public function quiz_process(Request $request, $id_user, $id_topic, $section)
    {
        $answer = $request->post();
        $question = Quizzes::where('id_topic', '=', $id_topic)->where('type', '=', $section)->get();
        $answer_right = 0;
        $answer_wrong = 0;

        foreach ($question as $qs) {
            $quiz_answer = $answer["quiz" . $qs->id];

            $grade_quiz = GradeQuiz::updateOrCreate(
                [
                    'id_quiz' => $qs->id,
                    'id_user' => $id_user
                ],
                [
                    'id_quiz' => $qs->id,
                    'id_user' => $id_user,
                    'user_answer' => $quiz_answer,
                    'is_right' => $qs->key == $quiz_answer ? 1 : 0
                ]
            );

            // count right and wrong answer
            if ($qs->key == $quiz_answer) {
                $answer_right++;
            } else {
                $answer_wrong++;
            }
        }

        // update or create Grade
        $grade = Grade::updateOrCreate(
            [
                'id_user' => $id_user,
                'id_topic' => $id_topic,
                'type' => $section
            ],
            [
                'id_user' => $id_user,
                'id_topic' => $id_topic,
                'type' => $section,
                'grade' => ($answer_right / ($answer_right + $answer_wrong)) * 100
            ]
        );
        return redirect()->route('detail.grade.show', $id_user)->withSuccess('Quiz updated successfully.');
    }
}
