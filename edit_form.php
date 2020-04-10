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
 * Form for editing Demo navigation instances.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Form for Demo navigation instances.
 *
 * @package block_demo
 * @author Ted Krahn
 * @copyright 2020 Athabasca University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_demo_edit_form extends block_edit_form {

    /**
     * This function defines the form.
     *
     * @param moodleform $mform The form object.
     */
    protected function specific_definition($mform) {

         // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block_demo'));

        // Yes/No select options for enabling block question.
        $options = array('yes' => get_string('yes'), 'no' => get_string('no'));
        $mform->addElement('select', 'config_enabletext', get_string('enabletext', 'block_demo'), $options);

        if (empty($this->block->config->enabletext) || $this->block->config->enabletext == 'no') {
            $mform->getElement('config_enabletext')->setSelected('no');
        } else {
            $mform->getElement('config_enabletext')->setSelected('yes');
        }

        // The block question itself.
        $mform->addElement('text', 'config_text', get_string('question', 'block_demo'));
        $mform->disabledIf('config_text', 'config_enabletext', 'eq', 'no');
        $mform->setType('config_text', PARAM_RAW);

        // The response to the student after they answer the question.
        $mform->addElement('text', 'config_text2', get_string('response', 'block_demo'));
        $mform->disabledIf('config_text2', 'config_enabletext', 'eq', 'no');
        $mform->setType('config_text2', PARAM_RAW);
    }
}