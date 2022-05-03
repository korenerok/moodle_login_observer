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

    protected static function classify_user($user){
        $id_teacher_or_staff=2;
        $id_student=3;
        $id_parent=4;
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
        if(substr($domain,-3)==".pr"){
            $match=[];
            if(preg_match("/de([0-9]+)/",$username,$match)===1 ){
                if($username===$match[0])
                    return $id_teacher_or_staff;
            }
            $match=[];
            if(preg_match("/e([0-9]+)/",$username,$match)===1 ){
                if($username===$match[0])
                    return $id_student;
            }
        }
        return 1;
    }
}
