<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Config;
use App\Models\Favorites;
use App\Models\Feedback;
use App\Models\GradeQuiz;
use App\Models\Histories;
use App\Models\Lessons;
use App\Models\LOs;
use App\Models\Topics;
use App\Models\TrackingLessons;
use App\Models\Task;
use App\Models\UserTask;
use App\Models\UserCertificate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\Events\Looping;
use Illuminate\Support\Facades\Facade;
use Illuminate\Validation\Rule;
use App\Models\Log;
use App\Models\Quizzes;
use App\Models\Grade;
use App\Traits\Check;
use App\Models\Rating;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    use Check;

    // Get Topic Data
    public function landing(Request $request)
    {
        $topic = Topics::all();
        foreach ($topic as $tp) {
            $count = 0;
            $lo = LOs::where('id_topic', $tp->id)->get();
            foreach ($lo as $l) {
                $lesson = Lessons::where('id_lo', $l->id)->get()->count();
                $count += $lesson;
            }
            $tp->{'count_lesson'} = $count;
        }

        // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' open all topics';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request all Topics information',
            'data' => $topic,
        ], 200);
    }

    // Get Topic Data
    public function waAdmin(Request $request)
    {
        $config = Config::all();
        $config = $config[0]->wa_admin;

        // Logging
        // $log = new Log();
        // $log->content = $request->user() . ' open all topics';
        // $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request admin WhatsApp',
            'data' => $config,
        ], 200);
    }

    // Get Topic Data
    public function topic(Request $request)
    {
        $topic = Topics::all();
        foreach ($topic as $tp) {
            $count = 0;
            $lo = LOs::where('id_topic', $tp->id)->get();
            foreach ($lo as $l) {
                $lesson = Lessons::where('id_lo', $l->id)->get()->count();
                $count += $lesson;
            }
            $tp->{'count_lesson'} = $count;
        }

        // Logging
        $log = new Log();
        $log->content = $request->user() . ' open all topics';
        $log->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request all Topics information',
            'data' => $topic,
        ], 200);
    }

    // Get LO Data from a Topic, using $id_topic as parameter
    public function lo(Request $request, $id_topic)
    {
        $lo = LOs::where('id_topic', '=', $id_topic)->get();
        $topic = Topics::find($id_topic);
        $count = 0;
        $lo = LOs::where('id_topic', $topic->id)->get();
        foreach ($lo as $l) {
            $lesson = Lessons::where('id_lo', $l->id)->get()->count();
            $count += $lesson;
        }
        $topic->{'count_lesson'} = $count;

        $array_lesson = [];
        foreach ($lo as $l) {
            $lesson = Lessons::where('id_lo', '=', $l->id)->get();
            foreach ($lesson as $ls) {
                $check = $this->check_favorit($request->user()->id, $ls->id);
                if ($check) {
                    $ls->{"is_favorit"} = 1;
                } else {
                    $ls->{"is_favorit"} = 0;
                }
                $tracked = $this->check_tracking($request->user()->id, $ls->id);
                if ($tracked) {
                    $ls->{"is_done"} = 1;
                } else {
                    $ls->{"is_done"} = 0;
                }
            }
            $l->{"data_lesson"} = $lesson;
        }

        $is_pre_test_done =  $this->check_pre_test($request->user()->id, $id_topic);
        $is_post_test_done =  $this->check_post_test($request->user()->id, $id_topic);
        $is_rated = $this->check_rating($request->user()->id, $id_topic);
        $is_feedback = $this->check_feedback($request->user()->id, $id_topic);

        // Logging
        $log = new Log();
        $log->content = $request->user() . ' open topic with ID : ' . $id_topic;
        $log->save();

        // Check if record exits
        $histories = Histories::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->first();
        if (!$histories) {
            $histories = new Histories();
            $histories->id_user = $request->user()->id;
            $histories->id_topic = $id_topic;
            $histories->status = "progress";
            $histories->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request detail Topic information',
            'data_topic' => $topic,
            'data_lo' => $lo,
            'histories' => $histories,
            'is_pre_test_done' => $is_pre_test_done,
            'is_post_test_done' => $is_post_test_done,
            'is_rated' => $is_rated,
            'is_feedback' => $is_feedback,
        ], 200);
    }

    // Get Lesson Data from a LO, using $id_lo as parameter
    public function lesson(Request $request, $id_lesson)
    {
        $data = Lessons::find($id_lesson);

        // Checking if record exits
        $lesson = Lessons::find($id_lesson);
        if ($lesson === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Lessons not found',
            ], 400);
        }

        // Check if record exits
        $tracking = TrackingLessons::where('id_user', '=', $request->user()->id)->where('id_lesson', '=', $id_lesson)->first();
        if (!$tracking) {
            $tracking = new TrackingLessons();
            $tracking->id_user = $request->user()->id;
            $tracking->id_lesson = $id_lesson;
            $tracking->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request lesson by ID',
            'data' => $data,
        ], 200);
    }

    // Get Question
    public function question(Request $request, $id_topic, $section)
    {
        // Check if record exits
        $tracking = Grade::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->where('type', '=', $section)->first();
        if ($tracking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'You have already do the test'
            ], 201);
        }


        if ($section != 'pre_test' and $section != 'post_test') {
            return response()->json([
                'status' => 'failed',
                'message' => 'You have wrong send question type'
            ], 201);
        }

        $question = Quizzes::where('id_topic', '=', $id_topic)->where('type', '=', $section)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request Quiz in Topic',
            'question' => $question,
        ], 200);
    }

    // Get Question
    public function answerQuestion(Request $request, $id_topic, $section)
    {
        // Check if record exits
        $tracking = Grade::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->where('type', '=', $section)->first();
        if ($tracking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'You have already do the test'
            ], 201);
        }

        if ($section != 'pre_test' and $section != 'post_test') {
            return response()->json([
                'status' => 'failed',
                'message' => 'You have wrong send question type'
            ], 201);
        }

        $question = Quizzes::where('id_topic', '=', $id_topic)->where('type', '=', $section)->count();
        if ($question > 0) {
            $answer = $request->content;
            $answer_array = [];
            $answer_right = 0;
            $answer_wrong = 0;
            $question_with_answer = [];
            foreach ($answer as $as) {
                $id_quiz = $as["id"];
                $user_answer = $as["answerUser"];

                $question = Quizzes::find($id_quiz);
                $question->{"user_answer"} = $as["answerUser"];

                $check = GradeQuiz::where('id_user', '=', $request->user()->id)->where('id_quiz', '=', $id_quiz)->first();
                if (!$check) {
                    $answer_save = new GradeQuiz();
                    $answer_save->id_user = $request->user()->id;
                    $answer_save->id_quiz = $id_quiz;
                    $answer_save->user_answer = $user_answer;

                    $question_answer = $question->key;
                    if ($question_answer == $user_answer) {
                        $answer_save->is_right = 1;
                        $answer_right++;
                        $question->{"is_right"} = 1;
                    } else {
                        $answer_save->is_right = 0;
                        $question->{"is_right"} = 0;
                        $answer_wrong++;
                    }

                    $answer_save->save();

                    array_push($answer_array, $user_answer);
                    array_push($question_with_answer, $question);
                }
            }

            $grade = new Grade();
            $grade->id_user = $request->user()->id;
            $grade->id_topic = $id_topic;
            $grade->type = $section;

            $final_grade = ($answer_right / ($answer_right + $answer_wrong)) * 100;
            $grade->grade = $final_grade;
            $grade->save();

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully send Quiz in Topic',
                'question' => $question_with_answer,
                'grade' => $grade,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'No Question Found'
            ], 201);
        }
    }

    public function answerResult(Request $request, $id_topic, $section)
    {
        // Check if record exits
        $tracking = Grade::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->where('type', '=', $section)->first();
        if (!$tracking) {
            return response()->json([
                'status' => 'failed',
                'message' => 'You must do the test first !'
            ], 201);
        }

        if ($section != 'pre_test' and $section != 'post_test') {
            return response()->json([
                'status' => 'failed',
                'message' => 'You have wrong send question type'
            ], 201);
        }

        // =================================

        $question = Quizzes::where('id_topic', '=', $id_topic)->where('type', '=', $section)->get();
        $question_with_answer = [];
        foreach ($question as $qs) {
            $user_answer = GradeQuiz::where('id_quiz', '=', $qs->id)->where('id_user', '=', $request->user()->id)->first();
            if ($user_answer) {
                $qs->{"is_right"} = $user_answer->is_right;
                $qs->{"user_answer"} = $user_answer->user_answer;
                array_push($question_with_answer, $qs);
            }
        }

        $grade = Grade::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->where('type', '=', $section)->first();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully send Quiz in Topic',
            'question' => $question_with_answer,
            'grade' => $grade,
        ], 200);
    }

    // ================================================
    // =============== Tracking Section ===============
    // ================================================

    // Tracking new lesson
    // public function tracking_take_lesson(Request $request, $id_lesson)
    // {
    //     // Checking if record exits
    //     $lesson = Lessons::find($id_lesson);
    //     if ($lesson === null) {
    //         return response()->json([
    //             'status' => 'failed',
    //             'message' => 'Lessons not found',
    //         ], 400);
    //     }

    //     // Check if record exits
    //     $tracking = TrackingLessons::where('id_user', '=', $request->user()->id)->where('id_lesson', '=', $id_lesson)->first();
    //     if (!$tracking) {
    //         $tracking = new TrackingLessons();
    //         $tracking->id_user = $request->user()->id;
    //         $tracking->id_lesson = $id_lesson;
    //         $tracking->save();
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'You have successfully create lesson tracking',
    //         'data' => $tracking,
    //     ], 200);
    // }

    // Tracking complete a course
    // public function tracking_done_course(Request $request, $id_topic)
    // {

    //     $histories = Histories::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->get()[0];
    //     $histories->status = "done";
    //     $histories->save();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'You have successfully update topic tracking',
    //         'data' => $histories,
    //     ], 200);
    // }

    // =================================================
    // =============== History Section ===============
    // =================================================

    // History : Index
    public function history(Request $request)
    {
        $histories = Histories::with('topic')->where('id_user', '=', $request->user()->id)->get();
        foreach ($histories as $ht) {
            $topic = $ht->topic;
            $count_lesson = 0;
            $count = 0;
            if ($topic) {
                $lo = LOs::where('id_topic', $topic->id)->get();
                foreach ($lo as $l) {
                    $lesson = Lessons::where('id_lo', $l->id)->get()->count();
                    $count_lesson += $lesson;
                    $tracking = TrackingLessons::where('id_user', '=', $request->user()->id)->where('id_lesson', '=', $l->id)->get();
                    if ($tracking) {
                        $count++;
                    }
                }
                if ($count_lesson == 0) {
                    $ht->{"precentage_done"} = 0;
                } else {
                    $ht->{"precentage_done"} = ($count / $count_lesson) * 100;
                }
            } else {
                $ht->{"precentage_done"} = 0;
            }
        }

        // Checking if record exits
        if ($histories === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'History empty',
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request history',
            'data' => $histories,
        ], 200);
    }

    // =================================================
    // =============== Favorites Section ===============
    // =================================================

    // Favorit : Index
    public function favorit_index_lesson(Request $request)
    {
        $favorit = Favorites::where('id_user', '=', $request->user()->id)->get();
        foreach ($favorit as $fv) {
            $lesson = Lessons::find($fv->id);
            $fv->{'detail_lesson'} = $lesson;
        }

        // Checking if record exits
        if ($favorit === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Favorit not found',
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request favorit',
            'data' => $favorit,
        ], 200);
    }

    // Favorit : Add Lesson
    public function favorit_add_lesson(Request $request, $id_lesson)
    {
        // Checking if record exits
        $lesson = Lessons::find($id_lesson);
        if ($lesson === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Lessons not found',
            ], 400);
        }

        $check = $this->check_favorit($request->user()->id, $id_lesson);
        if (!$check) {
            $favorit = new Favorites();
            $favorit->id_user = $request->user()->id;
            $favorit->id_lesson = $id_lesson;
            $favorit->save();
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Lesson already added',
            ], 400);
        }



        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully add lesson to favorit',
            'data' => $favorit,
        ], 200);
    }

    // Favorit : Delete Lesson
    public function favorit_remove_lesson(Request $request, $id_lesson)
    {
        $check = $this->check_favorit($request->user()->id, $id_lesson);
        if (!$check) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Lesson already deleted',
            ], 400);
        } else {
            $favorit = Favorites::where('id_user', '=', $request->user()->id)->where('id_lesson', '=', $id_lesson)->get()[0];
            $favorit->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully remove lesson from favorit',
            ], 200);
        }
    }

    // =================================================
    // ==================== Feedback & Rating ===================
    // =================================================

    // Add feedback topic
    public function feedback_add(Request $request, $id_topic)
    {
        $validator = Validator::make($request->all(), [
            'feedback' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ], 400);
        }

        $topic = Topics::find($id_topic);
        // Check if record exits
        if ($topic === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Topic not found',
            ], 400);
        }

        $check = $this->check_feedback($request->user()->id, $id_topic);
        if (!$check) {
            $feedback = new Feedback();
            $feedback->id_user = $request->user()->id;
            $feedback->id_topic = $id_topic;
            $feedback->feedback = $request->feedback;
            $feedback->save();

            // History Done
            $histories = Histories::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->first();
            $histories->status = "completed";
            $histories->save();

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully add feedback to topic',
                'data' => $feedback,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Feedback already added',
            ], 400);
        }
    }

    // Add feedback topic
    public function rating_add(Request $request, $id_topic)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ], 400);
        }

        $topic = Topics::find($id_topic);
        // Check if record exits
        if ($topic === null) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Topic not found',
            ], 400);
        }

        // check rating and response
        $check = $this->check_rating($request->user()->id, $id_topic);
        if (!$check) {
            $rating = new Rating();
            $rating->id_user = $request->user()->id;
            $rating->id_topic = $id_topic;
            $rating->rating = $request->rating;
            $rating->save();
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully add rating to topic',
                'data' => $rating,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Rating already added',
            ], 400);
        }
    }

    //
    public function announcement()
    {
        $announcement = Announcement::all();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request announcement',
            'data' => $announcement,
        ], 200);
    }

    // Get Task
    public function task(Request $request, $id_topic)
    {
        $task = Task::where('id_topic', '=', $id_topic)->get();

        // Check if record exits
        $user_task = UserTask::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->first();
        if ($user_task) {
            $task->{"user_task"} = $user_task;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request Task in Topic',
            'task' => $task,
        ], 200);
    }

    // Post Task
    public function answerTask(Request $request, $id_topic)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        $task = Task::where('id_topic', '=', $id_topic)->first();

        // Upload File
        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('task'), $file_name);

            $answerTask = UserTask::updateOrCreate(
                [
                    'id_topic' => $id_topic,
                    'id_user' => $request->user()->id,
                    'id_task' => $task->id
                ],
                [
                    'file' => "/task/" . $file_name,
                    'user_notes' => $request->user_notes,
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully send Task in Topic',
                'task' => $answerTask,
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'File not detected',
        ], 400);

    }

    // ==================== Certificate ==========================

    // Post Task
    public function certificate_list(Request $request)
    {
        $certificate = UserCertificate::where('id_user', '=', $request->user()->id)->get();
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request certificate list',
            'certificate' => $certificate,
        ], 200);
    }

    // Post Task
    public function certificate_template()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully request certificate template',
            'certificate' => url('/template/1790547123a8fea4e42795b3760474c6.png'),
        ], 200);
    }

    // Post Task
    public function certificate(Request $request, $id_topic)
    {
        $certificate = UserCertificate::where('id_user', '=', $request->user()->id)->where('id_topic', '=', $id_topic)->first();
        if ($certificate) {
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully request certificate',
                'certificate' => $certificate,
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'You must finish course first !',
            ], 400);
        }
    }

    // Post Task
    public function certificate_upload(Request $request, $id_topic)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg',
        ]);

        $user_certicate = UserCertificate::updateOrCreate(
            [
                'id_topic' => $id_topic,
                'id_user' => $request->user()->id,
                'number' => $request->user()->id,
            ],
            [
                'file' => Storage::disk('public')->put('user-certificates', $request->file('file')),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully send certificate',
            'certificate' => $user_certicate,
        ], 200);
    }
}
