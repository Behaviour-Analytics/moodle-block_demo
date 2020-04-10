<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The global block settings.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2019 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/user/lib.php');
global $USER;

// Get the user's username.
$username = $USER->firstname . ' ' . $USER->lastname;
$params = array('key' => $username);

// Settings header.
$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('adminheader', 'block_demo', $username),
    get_string('admindesc', 'block_demo', $params)
));

// Add the checkbox for this course for this user.
$settings->add(new admin_setting_configcheckbox(
    'block_demo/display_user',
    get_string('settingdesc', 'block_demo'),
    get_string('settingvalue', 'block_demo'),
    '0'
));

// Text for welcome message.
$settings->add(new admin_setting_configtext(
    'block_demo/display_text',
    get_string('label', 'block_demo'),
    get_string('desc', 'block_demo'),
    get_string('value', 'block_demo')
));
