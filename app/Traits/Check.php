<?php

namespace App\Traits;

use App\Models\Favorites;
use App\Models\Feedback;
use App\Models\Grade;
use App\Models\GradeQuiz;
use App\Models\Rating;
use App\Models\TrackingLessons;

trait Check
{
    public function check_favorit($id_user,$id_lesson)
    {
        $check = Favorites::where('id_user','=',$id_user)->where('id_lesson','=',$id_lesson)->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }

    public function check_feedback($id_user,$id_topic)
    {
        $check = Feedback::where('id_user','=',$id_user)->where('id_topic','=',$id_topic)->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }

    public function check_rating($id_user,$id_topic)
    {
        $check = Rating::where('id_user','=',$id_user)->where('id_topic','=',$id_topic)->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }

    public function check_tracking($id_user,$id_lesson)
    {
        $check = TrackingLessons::where('id_user','=',$id_user)->where('id_lesson','=',$id_lesson)->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }

    public function check_pre_test($id_user,$id_topic)
    {
        $check = Grade::where('id_user','=',$id_user)->where('id_topic','=',$id_topic)->where('type','=','pre_test')->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }

    public function check_post_test($id_user,$id_topic)
    {
        $check = Grade::where('id_user','=',$id_user)->where('id_topic','=',$id_topic)->where('type','=','post_test')->first();
        if ($check) {
            return True;
         } else {
             return False;
         }
    }
}
