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
 * This script is called by the client side JavaScript to store text.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Usual security stuff.
require_once(__DIR__.'/../../config.php');
require_once("$CFG->dirroot/blocks/demo/locallib.php");

defined('MOODLE_INTERNAL') || die();

$courseid = required_param('cid', PARAM_INT);
$textdata = required_param('data', PARAM_RAW);

require_sesskey();

$course = get_course($courseid);

require_login($course);
$context = context_course::instance($courseid);
require_capability('block/demo:view', $context);

// Clean the entered text.
$man = new block_demo_manager();
$text = $man->clean_text($textdata);

if (strlen($text) == 0) {
    die('');
}

// Simple DB table insertion.
$DB->insert_record('block_demo_text', (object) array(
    'courseid' => $courseid,
    'userid'   => $USER->id,
    'text'     => $text
));

die($text);