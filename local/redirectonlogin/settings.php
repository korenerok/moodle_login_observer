<?php

use local_eabcsocial\utils;

require_once('lib.php');
defined('MOODLE_INTERNAL') || die;
if ($hassiteconfig) { // needs this condition or there is error on login page
    global $DB;

    $title = get_string('pluginname', 'local_eabcsocial');
    $settings = new admin_settingpage('local_eabcsocial', $title);

    $displaylist = core_course_category::make_categories_list('moodle/course:create');

    $name = 'local_eabcsocial/categoryid';
    $description = get_string('desc_category', 'local_eabcsocial');
    $title = get_string('title_category', 'local_eabcsocial');
    $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    // $name = 'local_eabcsocial/category_self';
    // $description = get_string('desc_category_self', 'local_eabcsocial');
    // $title = get_string('title_category_self', 'local_eabcsocial');
    // $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    // $name = 'local_eabcsocial/category_manual';
    // $description = get_string('desc_category_manual', 'local_eabcsocial');
    // $title = get_string('title_category_manual', 'local_eabcsocial');
    // $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    $name = 'local_eabcsocial/limite_vistos';
    $description = get_string('desc_limite_vistos', 'local_eabcsocial');
    $title = get_string('title_limite_vistos', 'local_eabcsocial');
    $settings->add(new admin_setting_configtext($name, $title, $description, 5, PARAM_INT));

    $name = 'local_eabcsocial/message_enrol';
    $description = get_string('desc_message_enrol', 'local_eabcsocial');
    $title = get_string('title_message_enrol', 'local_eabcsocial');
    $settings->add(new admin_setting_configtext($name, $title, $description, 'NO SE PUEDE MATRICULAR EN ESTE CURSO', PARAM_TEXT));

    $categoryid = get_config('local_eabcsocial', 'categoryid');
    $array_cat = utils::get_list_valid_category($categoryid);

    $arraycats = [];
    foreach ($array_cat as $cat) {
        if ($cat == 1) {
            continue;
        }
        $category = $DB->get_record('course_categories', ['id' => $cat]);

        $arraycats[$cat] = $category->name;
    }

    foreach ($arraycats as $key => $catname) {
        $fileid = 'cat'.$key;
        $name = 'local_eabcsocial/catimage'.$key;
        $title = get_string('catimage', 'local_eabcsocial', $catname);
        $description = get_string('catimagedesc', 'local_eabcsocial', $catname);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid);
        $settings->add($setting);
    }
/*
    $name = 'local_eabcsocial/show_vigentes';
    $description = "Mostrar la sección de cursos Vigentes";
    $title = "Mostrar los cursos vigentes";
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, 0));

    $name = 'local_eabcsocial/show_masvistos';
    $description = "Mostrar la sección de cursos más vistos";
    $title = "Mostrar los cursos más vistos";
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, 0));

    $name = 'local_eabcsocial/show_sugeridos';
    $description = "Mostrar la sección de cursos sugeridos por vos";
    $title = "Mostrar los cursos sugeridos";
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, 0));

    $name = 'local_eabcsocial/show_asignados';
    $description = "Mostrar la sección de cursos asignados";
    $title = "Mostrar los cursos asignados";
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, 0));

    $name = 'local_eabcsocial/show_loquebuscas';
    $description = "Mostrar la sección que contiene: mis cursos, cursos por competencias, por categorías y por temática";
    $title = "Mostrar cursos por varios criterios";
    $settings->add(new admin_setting_configcheckbox($name, $title, $description, 0));
*/
    $ADMIN->add('localplugins', $settings);
}