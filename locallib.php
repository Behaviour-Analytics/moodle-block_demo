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
 * A library of various functions.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * The Demo block manager class.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_demo_manager {

    /**
     * Called to get the previously entered texts.
     *
     * @param int $courseid The course id value.
     * @return stdClass
     */
    public function block_demo_get_text($courseid) {
        global $DB, $USER;

        $params = array(
            'courseid' => $courseid,
            'userid'   => $USER->id
        );
        $records = $DB->get_records('block_demo_text', $params);

        return $records;
    }

    /**
     * Called to clean text entered in the answer form.
     *
     * @param string $textdata The entered text.
     * @return string
     */
    public function clean_text($textdata) {

        // Remove HTML and PHP tags.
        $text = strip_tags($textdata);
        // Add back slashes to quotation marks.
        $text = addslashes($text);
        // Sanitize input against SQL injection.
        $text = preg_replace('/;/', '', $text);

        return $text;
    }
}