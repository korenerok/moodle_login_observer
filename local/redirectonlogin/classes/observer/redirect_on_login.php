<?php

namespace local_redirectonlogin\observer;

use moodle_url;

require_once($CFG->dirroot.'/user/lib.php');

class redirect_on_login {
    public static function redirect_user(\core\event\user_loggedin $event) {
        $user=current(user_get_users_by_id([$event->userid]));
        $course_id=1;
        if(count(get_courses())>1){
            $course_id=self::classify_user($user);
        }
        redirect(new moodle_url('/course/view.php',['id'=>$course_id,'email'=>$user->email]));
    }

}
