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

namespace tool_grischeras;

use tool_grischeras\event\delete_item;

/**
 * Class description.
 */
class grischeras_observer {

    /**
     * Method description.
     *
     * @param delete_item $event
     * @return void
     */
    public static function delete_item(delete_item $event) {
          global $DB;
          $DB->delete_records('tool_grischeras', ['id' => $event->objectid]);
    }
}
