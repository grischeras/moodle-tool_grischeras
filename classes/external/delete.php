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

use context_system;
use core_external\external_function_parameters;
use core_external\external_value;
use tool_grischeras\event\delete_item;
use tool_grischeras\item;

/**
 * Class description.
 */
class delete extends \core_external\external_api {
    /**
     * Get the function parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'itemid' => new external_value(PARAM_INT, 'The id of the item to delete'),
        ]);
    }

    /**
     * Method description
     *
     * @param int $itemid
     * @return void
     */
    public static function execute(int $itemid): void {
        self::validate_context(context_system::instance());
        self::validate_parameters(self::execute_parameters(), ['itemid' => $itemid]);
        $event = delete_item::create([
            'context' => context_system::instance(),
                'objectid' => $itemid,
        ]);
        $event->add_record_snapshot('tool_grischeras_delete_item', self::get_record($itemid));
        $event->trigger();
    }

    /**
     * We don't need to return anything.
     */
    public static function execute_returns() {
        return null;
    }

    /**
     * Method description
     *
     * @param int $itemid
     * @return false|mixed|\stdClass
     */
    private static function get_record(int $itemid) {
        global $DB;

        return $DB->get_record('tool_grischeras', ['id' => $itemid]);
    }
}
