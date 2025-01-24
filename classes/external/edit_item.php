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

namespace tool_grischeras\external;

use context_course;
use core_external\external_function_parameters;
use core_external\external_value;
use tool_grischeras\item;

/**
 * Class description.
 */
class edit_item extends \core_external\external_api {
    /**
     * Get the function parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'itemid' => new external_value(PARAM_INT, 'The id of the item to edit'),
            'name' => new external_value(PARAM_RAW, 'name of the item to edit'),
            'completed' => new external_value(PARAM_RAW, 'if the item to edit is completed'),
            'priority' => new external_value(PARAM_INT, 'priority of the item to edit'),
        ]);
    }


    /**
     * Method description.
     *
     * @param int $itemid
     * @param string $name
     * @param bool $completed
     * @param int $priority
     * @return void
     */
    public static function execute(int $itemid, string $name, bool $completed, int $priority): void {

        self::validate_parameters(self::execute_parameters(), [
            'itemid' => $itemid,
            'name' => $name,
            'completed' => $completed,
            'priority' => $priority,
        ]);
        $item = new item('tool_grischeras');
        $courseid = $item->get_item($itemid)->courseid;
        self::validate_context(context_course::instance($courseid));
        $object = new \stdClass();
        $object->name = $name;
        $object->priority = $priority;
        $object->completed = $completed;
        $item->update_item($itemid, $object);
    }

    /**
     * We don't need to return anything.
     */
    public static function execute_returns() {
        return null;
    }
}
