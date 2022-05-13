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
        redirect(new moodle_url('/course/view.php',['id'=>$course_id]));
    }

    protected static function classify_user($user){

        $id_teacher_or_staff=get_config('local_redirectonlogin','home_course_teacher');
        $id_student=get_config('local_redirectonlogin','home_course_student');
        $id_parent=get_config('local_redirectonlogin','home_course_parent');
        if($user->auth=='manual'){
            return $id_parent;
        }
        if($domain=explode('@',$user->email)){
            $username=$domain[0];
            $domain=$domain[1];
        }
        if($domain=='itec.pr' || $domain=='de.pr.gov'){
            return $id_teacher_or_staff;
        }
        if($domain=="miescuela.pr"){
            if(preg_match("/^de([0-9]+)$/",$username)===1 ){
                return $id_teacher_or_staff;
            }
            if(preg_match("/^e([0-9]+)$/",$username)===1 ){
                    return $id_student;
            }
        }
        return 1;
    }
}
