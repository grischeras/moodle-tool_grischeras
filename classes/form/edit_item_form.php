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
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace tool_grischeras\form;

use moodleform;

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->libdir . '/formslib.php');

class edit_form extends moodleform {
    // Add elements to form.
    public function definition() {
        global $PAGE;

        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!

        // Add elements to your form.
        $mform->addElement('text', 'email'  );

        // Set type of element.
        $mform->setType('email', PARAM_NOTAGS);

        // Default value.
        $mform->setDefault('email', 'Please enter email');
    }

    // Custom validation should be added here.
    function validation($data, $files) {
        return [];
    }
}
