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



use App\Models\Education;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductVariant;
use App\Models\Thread;
use App\Models\Project;
use App\Models\ProjectFunding;

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
            'data' => $user
        ], 200);
    }

    public function detail_tips(Request $request, $id)
    {
        $data = Education::find($id);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function detail_berita(Request $request, $id)
    {
        $data = Thread::find($id);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function detail_funding(Request $request, $id)
    {
        $data = Project::find($id);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data not found',
            ], 404);
        }

        $total_funding = ProjectFunding::where('id_project', $id)->sum('amount');

        if ($total_funding > $data->target) {
            $total_funding = $data->target;
        }

        if(!$total_funding == 0){
            $data->{"total_goal"} = round(($total_funding / $data->target ) * 100 , 2);
        }else{
            $data->{"total_goal"} = 0;
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function detail_produk(Request $request, $id)
    {
        $data = Product::find($id);
        if (!$data) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Data not found',
            ], 404);
        }

        $product_variant = ProductVariant::where('id_product', $id)->get();
        $data->{"product_variant"} = $product_variant;

        $rating = 0;
        if(!ProductReview::where('id_product', $id)->get()->count() == 0){
            $rating = ProductReview::where('id_product', $id)->get()->sum('rating') / ProductReview::where('id_product', $id)->get()->count();
        }

        $data->{"rating"} = round($rating , 1);


        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function forum(Request $request)
    {
        $post = Thread::all();
        $news = Thread::all();
        $tips = Education::all();

        return response()->json([
            'status' => 'success',
            'data' => [
                'post' => $post,
                'news' => $news,
                'tips' => $tips,
            ]
        ], 200);
    }
}
