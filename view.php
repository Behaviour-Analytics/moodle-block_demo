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
 * A script for viewing an arbitrary page.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Standard security stuff follows...
require_once(__DIR__.'/../../config.php');
require_once("$CFG->dirroot/blocks/demo/locallib.php");
require_once("$CFG->dirroot/blocks/demo/classes/answer-form.php");

defined('MOODLE_INTERNAL') || die();

$id = required_param('id', PARAM_INT);

$course = get_course($id);
require_login($course);

$context = context_course::instance($course->id);
require_capability('block/demo:view', $context);

// Make the answer form.
$text = '';
$url = new moodle_url('/blocks/demo/view.php', array('id' => $id));
$rform = new answer_form($url, null, 'post', null, array('id' => "block_demo_response-form"));

// If the form has been submitted, process the submission.
if ($fd = $rform->get_data()) {

    // Clean the answer text before insertion.
    $man = new block_demo_manager();
    $text = $man->clean_text($fd->answer);

    if (strlen($text) > 0) {
        // Simple DB table insertion.
        $DB->insert_record('block_demo_text', (object) array(
            'courseid' => $id,
            'userid'   => $USER->id,
            'text'     => $text
        ));
    }
    // Reload the page so the entered answer shows.
    sleep(2);
    redirect($url);
}

// Set up the page.
$PAGE->set_url('/blocks/demo/view.php', array('id' => $course->id));
$PAGE->set_title(get_string('pluginname', 'block_demo'));

// Set up the client side JavaScript.
$PAGE->requires->js_call_amd('block_demo/modules', 'init');
$PAGE->requires->js_init_call('waitForModules', [], true);
$PAGE->requires->js('/blocks/demo/javascript/main.js');

$PAGE->requires->string_for_js('jsstring', 'block_demo');
$PAGE->requires->string_for_js('notext', 'block_demo');
$PAGE->requires->string_for_js('textsent', 'block_demo');

// Finish setting up page.
$PAGE->set_pagelayout('standard'); // Page type 'popup' is useful for debugging.
$PAGE->set_heading($course->fullname);

// Get previously entered texts.
$man = new block_demo_manager();
$textdata = $man->block_demo_get_text($id);

// Output page.
echo $OUTPUT->header();

// Display the form.
$rform->display();

// Empty placeholder for feedback message after clicking button.
echo html_writer::tag('p', '&nbsp', array('id' => 'block_demo_outtext'));

// Display previously entered texts.
echo html_writer::div(get_string('entered', 'block_demo'));
echo html_writer::empty_tag('br');

echo html_writer::start_tag('div', array('id' => 'block_demo_texts'));
foreach ($textdata as $td) {
    echo html_writer::tag('p', stripslashes($td->text));
}

echo html_writer::tag('p', $text); // Just entered text.
echo html_writer::end_tag('div');

echo $OUTPUT->footer();

