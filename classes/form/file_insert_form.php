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
 * A short description of the class.
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_grischeras\form;

use moodleform;

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->libdir . '/formslib.php');

/**
 * Class description.
 */
class file_insert_form extends moodleform {

    /**
     * Method description.
     *
     * @return void
     */
    protected function definition() {
        global $PAGE;
        $mform = $this->_form; // Don't forget the underscore!
        $mform->addElement(
            'filepicker',
            'userfile',
            get_string('file'),
            null,
            [
                'maxbytes' => '8',
                'accepted_types' => 'csv',
            ]
        );

        // Add hidden element for 'courseid'.
        $mform->addElement('hidden', 'courseid', required_param('courseid', PARAM_INT));
        $mform->setType('courseid', PARAM_INT); // Make sure hidden elements also have their type set.

        $this->add_action_buttons();
    }
}
