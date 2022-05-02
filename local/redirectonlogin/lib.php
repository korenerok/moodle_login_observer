<?php

/**
 * @throws coding_exception
 */
function local_redirectonlogin_before_standard_top_of_body_html()
{

    global $PAGE,$CFG;

    $params = (object)[
        'title' => get_string('mostviewedcourses', 'local_redirectonlogin'),
        'criteria' => 'mostviewed',
        'nocourses' => get_string('nocourses', 'local_redirectonlogin'),
    ];
    $PAGE->requires->js_call_amd('local_redirectonlogin/main', 'initSlider', [$params]);


    $usertagpreferences= (new moodle_url($CFG->wwwroot . '/local/eabcsocial/preferences.php')) -> out();

    $params = (object)[
        'title' => get_string('recommendedcourses', 'local_redirectonlogin'),
        'criteria' => 'recommended',
        'nocourses' => get_string('nocoursesmatchestags', 'local_redirectonlogin',$usertagpreferences)
    ];
    $PAGE->requires->js_call_amd('local_redirectonlogin/main', 'initSlider', [$params]);
}

/**
 * @param $course
 * @param $cm
 * @param $context
 * @param $filearea
 * @param $args
 * @param $forcedownload
 * @param array $options
 * @throws moodle_exception
 */
function local_redirectonlogin_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array())
{
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_redirectonlogin', $filearea, $args[0], '/', $args[1]);

    \core\session\manager::write_close();
    send_stored_file($file, null, 0, $forcedownload);
}

/**
 * @param $navigation
 * @throws coding_exception
 */
function local_redirectonlogin_extend_navigation_user_settings($navigation)
{
    $node = navigation_node::create(
        get_string('coursepreferences', 'local_redirectonlogin'),
        new moodle_url('/local/eabcsocial/preferences.php'),
        navigation_node::TYPE_SETTING,
        null,
        'socialpreferences',
        new pix_icon('i/settings', '')
    );

    if (isset($node) && !empty($navigation)) {
        $navigation->add_node($node);
    }

}
