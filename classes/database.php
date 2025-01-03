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

class database {
    /**
     * @var string
     */
    protected string $table;
    /**
     * @var object
     */
    protected object $item;

    /**
     * @return void
     */
    protected function save(): void {
        global $DB;
        if ($this->item->id) {
            $DB->update_record($this->table, $this->item);
        } else {
            $id = $DB->insert_record($this->table, $this->item);
            $this->get_one_by_id($id);
        }
    }

    /**
     * @param int $id
     */
    protected function get_one_by_id(int $id): void {
        global $DB;
        $params = ['id' => $id];

        $this->item = $DB->get_record($this->table, $params);
    }

    /**
     * @return bool
     */
    protected function delete(): bool {
        global $DB;

        return $DB->delete_records($this->table,['id' => $this->item->id]);
    }
}
