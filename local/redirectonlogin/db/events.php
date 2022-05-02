<?php

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        "eventname" => "\\core\\event\\user_loggedin",
        "callback" => "\\local_redirectonlogin\\observer\\redirect_on_login::redirect_user",
        "internal" => false
    ),
);


