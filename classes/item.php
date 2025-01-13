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
 * a short description of my plugin edit actions
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_grischeras;

use tool_grischeras\database;

/**
 * Class description.
 */
class item extends database {
    /**
     * Method description.
     *
     * @param string $table
     */
    public function __construct(string $table) {
        $this->table = $table;
    }

    /**
     * Method description.
     *
     * @param int $id
     * @return object
     */
    public function get_item(int $id): object {
        $this->get_one_by_id($id);

        return  $this->item;
    }

    /**
     * Method description.
     *
     * @param int $id
     * @param \stdClass $data
     * @return object
     */
    public function update_item(int $id, \stdClass $data): object {
        $this->get_item($id);
        $this->item->name = $data->name;
        $this->item->priority = $data->priority;
        $this->item->completed = $data->completed;
        $this->save();

        return $this->item;
    }

    /**
     * Method description.
     *
     * @param int $id
     * @return bool
     */
    public function delete_item(int $id): bool {
        $this->get_item($id);

        return $this->delete();
    }

    public function insert_item(\stdClass $data): int {
        $this->item = $data;
        $this->save();

        return $this->item->id;
    }
}
