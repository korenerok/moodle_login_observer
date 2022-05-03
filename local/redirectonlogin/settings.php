<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     local_redirectonlogin
 * @category    local
 * @copyright   2022 @korenerok <marvin.bernal@gmx.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) { // needs this condition or there is error on login page
    global $DB;

    $title = get_string('pluginname', 'local_redirectonlogin');
    $settings = new admin_settingpage('local_redirectonlogin', $title);

    $displaylist=get_courses();

    $name = 'local_redirectonlogin/home_course_student';
    $description = get_string('home_course_student_desc', 'local_redirectonlogin');
    $title = get_string('home_course_student', 'local_redirectonlogin');
    $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    $name = 'local_redirectonlogin/home_course_teacher_or_staff';
    $description = get_string('home_course_teacher_or_staff_desc', 'local_redirectonlogin');
    $title = get_string('home_course_teacher_or_staff', 'local_redirectonlogin');
    $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    $name = 'local_redirectonlogin/home_course_parent';
    $description = get_string('home_course_parent_desc', 'local_redirectonlogin');
    $title = get_string('home_course_parent', 'local_redirectonlogin');
    $settings->add(new admin_setting_configselect($name, $title, $description, key($displaylist), $displaylist));

    $ADMIN->add('localplugins', $settings);
}