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
 * A simple form clas.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * Class to make the response form.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class answer_form extends moodleform {
    /**
     * Add elements to form.
     */
    public function definition() {

        $mform = $this->_form; // Don't forget the underscore!

        $label = get_string('answerlabel', 'block_demo');
        $mform->addElement('text', 'answer', $label, array('id' => "block_demo_inputtext"));
        $mform->setType('answer', PARAM_NOTAGS);

        $mform->addElement('html', '<br\>');

        $this->add_action_buttons(false, get_string('buttontext', 'block_demo'));
    }
}
