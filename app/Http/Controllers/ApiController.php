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
    public function update_tb_bb_color(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'berat_badan' => 'required',
            'tinggi_badan' => 'required',
            'warna_kulit' => 'required|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors(),
            ], 400);
        }

        $user = $request->user();
        $user->height = $request->tinggi_badan;
        $user->weight = $request->berat_badan;
        $user->skin_color = $request->warna_kulit;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully update your profile !',
            'data' => $user
        ], 200);
    }
}
