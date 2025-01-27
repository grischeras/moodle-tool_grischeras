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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/moodle2/restore_tool_plugin.class.php');

/**
 * Class description.
 */
class restore_tool_grischeras_plugin extends restore_tool_plugin {

    /**
     * Method descritpion.
     *
     * @return array
     */
    protected function define_course_plugin_structure() {
        $paths[] = new restore_path_element('tool_grischeras', '/course/tool_grischeras');
        return $paths;
    }


    /**
     * Method description.
     * 
     * @param $data
     * @return void
     */
    public function process_tool_grischeras($data): void {
        global $DB;
        $data = (object) $data;
        // Store the old id.
        $oldid = $data->id;
        // Change the values before we insert it.
        $data->courseid = $this->task->get_courseid();
        $data->timecreated = time();
        $data->timemodified = $data->timecreated;
        // Now we can insert the new record.
        $data->id = $DB->insert_record('tool_grischeras', $data);
        // Set up the mapping.
        $this->set_mapping('tool_grischeras', $oldid, $data->id);

        $this->add_related_files('tool_grischeras', 'comments', null);
    }
}
