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
 * @copyright  2025 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_grischeras\form;
use moodleform;


defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->libdir . '/formslib.php');

class delete_confirmation_form extends moodleform
{

    /**
     * @inheritDoc
     */
    protected function definition()
    {
        global $PAGE;
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!
        $item = $this->get_item();
        $mform->addElement('static', 'delete_confirmation','Delete Confirmation','');
        $this->add_action_buttons();
    }

    /**
     * Method description.
     *
     * @return object
     */
    private function get_item(): object {
        global $DB;
        $itemid = required_param('itemid', PARAM_INT);
        $params = ['id' => $itemid];

        return $DB->get_record('tool_grischeras', $params);
    }
}