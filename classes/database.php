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
 * a short description of my plugin database
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_grischeras;

use stdClass;

/**
 * Class description.
 */
class database {
    /**
     * @var string
     */
    protected string $table;
    /**
     * @var object|null
     */
    protected ?object $item;

    /**
     * Method description.
     *
     * @return void
     */
    protected function save(): void {
        global $DB;
        if ($this->item->id) {
            $this->item->timemodified = time();
            $DB->update_record($this->table, $this->item);
        } else {
            $id = $DB->insert_record($this->table, $this->item);
            $this->get_one_by_id($id);
        }
    }

    /**
     * Method description.
     *
     * @param int $id
     */
    protected function get_one_by_id(int $id): void {
        global $DB;
        $this->item = null;
        $params = ['id' => $id];
        $record = $DB->get_record($this->table, $params);
        if ($record) {
            $this->item = $record;
        }

    }

    /**
     * Method description.
     *
     * @return bool
     */
    protected function delete(): bool {
        global $DB;

        return $DB->delete_records($this->table, ['id' => $this->item->id]);
    }

    /**
     * Method description.
     *
     * @param stdClass $item
     * @return bool
     */
    protected function get_one_by_name_courseid(stdClass $item): bool {
        global $DB;
        $this->item = null;
        $params = ['name' => $item->name, 'courseid' => $item->courseid];
        $record = $DB->get_record($this->table, $params);
        if ($record) {
            return true;
        }

        return false;
    }
}
