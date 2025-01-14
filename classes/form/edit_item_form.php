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
use stdClass;

defined('MOODLE_INTERNAL') || die;

global $CFG;

require_once($CFG->libdir . '/formslib.php');

/**
 * Form for editing.
 */
class edit_item_form extends moodleform {
    /**
     * Add elements to form.
     *
     * @return void
     */
    public function definition(): void {
        global $PAGE;
        $mform = $this->_form; // Don't forget the underscore!
        $item = $this->get_item();

        // Add elements to your form.
        $mform->addElement('text', 'name', 'Name');
        $mform->setType('name', PARAM_TEXT); // Correct field name here.
        $mform->setDefault('name', $item->name);

        // Add radio buttons for 'completed'.
        $radioarray = [];
        $radioarray[] = $mform->createElement('radio', 'completed', '', get_string('yes'), 1, 'completed');
        $radioarray[] = $mform->createElement('radio', 'completed', '', get_string('no'), 0, 'completed');
        $mform->addGroup($radioarray, 'radioar', 'Completed', [' '], false);
        $mform->setDefault('completed', $item->completed);

        // Add select dropdown for 'priority'.
        $select = $mform->addElement('select', 'priority', 'Priority', $this->get_priorities());
        $select->setSelected($item->priority);

        // Add hidden element for 'courseid'.
        $mform->addElement('hidden', 'courseid', $item->courseid);
        $mform->setType('courseid', PARAM_INT); // Make sure hidden elements also have their type set.

        $this->add_action_buttons();

    }

    /**
     * Perform some extra moodle validation.
     * @param array $data
     * @param array $files
     * @return array
     */
    public function validation($data, $files = []): array {
        $errors = [];
        if (empty($data['name'])) {
            $errors['name'] = get_string('requiredname', 'tool_grischeras');
        }
        if ($data['priority'] < 1 || $data['priority'] > 10) {
            $errors['priority'] = get_string('requiredpriority', 'tool_grischeras');
        }
        if ($data['completed'] < 0 || $data['completed'] > 1) {
            $errors['completed'] = get_string('requiredcompleted', 'tool_grischeras');
        }
        return $errors;
    }

    /**
     * Method description.
     *
     * @return object
     */
    private function get_item(): object {
        global $DB;

        $itemid = optional_param('itemid', null, PARAM_INT);
        if ($itemid) {
            $params = ['id' => $itemid];
            $item = $DB->get_record('item', $params);
        } else {
            $item = new stdClass();
            $item->completed = 0;
            $item->priority = 1;
            $item->name = '';
            $item->courseid = required_param('courseid', PARAM_INT);
        }

        return $item;
    }

    /**
     * Method description.
     *
     * @return array
     */
    private function get_priorities(): array {
        $result = [];
        for ($index = 1; $index <= 10; $index++) {
            $result[$index] = $index;
        }

        return $result;
    }
}

