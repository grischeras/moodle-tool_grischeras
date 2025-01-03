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
        // A reference to the form is stored in $this->form.
        // A common convention is to store it in a variable, such as `$mform`.
        $mform = $this->_form; // Don't forget the underscore!
        $item = $this->get_item();
        // Add elements to your form.
        $mform->addElement('text', 'name', 'Name');
        // Set type of element.
        $mform->setType('text', PARAM_TEXT);
        // Default value.
        $mform->setDefault('name', $item->name);
        // Add elements to your form.
        $radioarray = [];
        $radioarray[] = $mform->createElement('radio', 'completed', '', get_string('yes'), 1, 'completed');
        $radioarray[] = $mform->createElement('radio', 'completed', '', get_string('no'), 0, 'completed');
        $mform->addGroup($radioarray, 'radioar', 'Completed', [' '], false);
        // Default value.
        $mform->setDefault('completed', $item->completed);

        $select = $mform->addElement('select', 'priority', 'Priority', $this->get_priorities());
        $select->setSelected($item->priority);

        $this->add_action_buttons();

    }

    // Perform some extra moodle validation.
    /**
     * @param $data
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

        return $errors;
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

