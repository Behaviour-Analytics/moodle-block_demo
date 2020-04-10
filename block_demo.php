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
 * Block demo is defined here.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->dirroot/blocks/demo/classes/answer-form.php");

/**
 * Demo block.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_demo extends block_base {

    /**
     * Initializes class member variables.
     */
    public function init() {
        // Needed by Moodle to differentiate between blocks.
        $this->title = get_string('pluginname', 'block_demo');
    }

    /**
     * Returns the block contents.
     *
     * @return stdClass The block contents.
     */
    public function get_content() {
        global $COURSE, $USER, $PAGE;

        // Some standard tests.
        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        // Do not show block for unauthorized users.
        $context = context_course::instance($COURSE->id);
        if (!has_capability('block/demo:view', $context)) {
            return null;
        }

        // Get this content set up.
        $this->content = new stdClass();
        $this->content->text = '';

        // Optionally display user name, if setting is checked.
        if (get_config('block_demo', 'display_user')) {
            $params = array(
                'welcome' => get_config('block_demo', 'display_text'),
                'first'    => $USER->firstname,
                'last'     => $USER->lastname
            );
            $this->content->text .= html_writer::tag('p', get_string("displayuser", "block_demo", $params));
        }

        // Launch new page anchor.
        $this->content->text .= html_writer::tag('a', get_string("launch", "block_demo"),
            array('href' => new moodle_url('/blocks/demo/view.php', array(
                'id' => $COURSE->id
            ))));
        $this->content->text .= html_writer::empty_tag('br');

        // Optionally display a question with text entry box and button.
        if ($this->config->enabletext == 'yes') {

            // Dislpay the question.
            $this->content->text .= html_writer::tag('p', $this->config->text);

            // A non-displayed target for form submit.
            $this->content->text .= html_writer::tag
                ('iframe', '', array('style' => 'display:none', 'name' => 'block_demo_target'));

            // Dislpay the answer form.
            $url = new moodle_url('/blocks/demo/store-text.php');
            $rform = new answer_form($url, null, 'post', 'block_demo_target', array('id' => "block_demo_response-form"));
            $this->content->text .= $rform->render();

            // Placeholder for response to answer submission.
            $this->content->text .= html_writer::tag('p', '&nbsp', array('id' => 'block_demo_outtext'));
            $this->content->text .= html_writer::empty_tag('br');

            // JavaScript to send the entered text to the server.
            $out = array(
                'url'      => (string) $url,
                'courseid' => $COURSE->id,
                'sesskey'  => sesskey(),
                'response' => $this->config->text2
            );
            $PAGE->requires->js(new moodle_url('/blocks/demo/javascript/send-text.js'));
            $PAGE->requires->js_init_call('initSendText', array($out), true);
            $PAGE->requires->string_for_js('notext', 'block_demo');
        }

        $this->content->footer = '';
        return $this->content;
    }

    /**
     * Defines configuration data.
     *
     * The function is called immediatly after init().
     */
    public function specialization() {

        // Load user defined title and make sure it's never empty.
        if (empty($this->config->title)) {
            $this->title = get_string('pluginname', 'block_demo');
        } else {
            $this->title = $this->config->title;
        }
    }

    /**
     * Sets the applicable formats for the block.
     *
     * @return string[] Array of pages and permissions.
     */
    public function applicable_formats() {
        return array(
            'course' => true,
        );
    }

    /**
     * Allow only one block instance per course.
     *
     * @return boolean
     */
    public function instance_allow_multiple() {

        return false;
    }

    /**
     * Ensure global settings are available. This function is required to
     * display the global settings page.
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }
}
