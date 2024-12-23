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
 * a short description about index_page
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace tool_grischeras\output;

use dml_exception;
use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * The class to render plugin's index page
 * @package    tool_grischeras
 */
class index_page implements renderable, templatable {

    /** @var string
     * $sometext Some text to show how to pass data to a template.
     */
    private string $sometext;
    /**
     * @var stdClass
     * $course instance
     */
    private stdClass $course;

    public function __construct(string $sometext, stdClass $course) {
        $this->sometext = $sometext;
        $this->course = $course;
    }

    /**
     *  a short description for this method
     * @param renderer_base $output
     * @return stdClass
     * @throws dml_exception
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->sometext = $this->sometext;
        $data->courseinfos = $this->get_course_infos();

        return $data;
    }

    /**
     * building data array
     * @return array
     * @throws dml_exception
     */
    private function get_course_infos(): array {
        return [
            'coursename' => $this->course->fullname,
            'isended' => ($this->course->enddate < time()),
            'students' => $this->get_course_participants('student'),
            'teachers' => $this->get_course_participants('teacher'),
        ];
    }

    /**
     * querying students enrolled in a course
     * @param string $archetype
     * @return int
     * @throws dml_exception
     */
    private function get_course_participants(string $archetype): int {
        global $DB;

        $sql = '
                SELECT COUNT({user_enrolments}.id) 
                FROM {user_enrolments} 
                INNER JOIN {enrol} ON {enrol}.id = {user_enrolments}.enrolid 
                INNER JOIN {role} ON {role}.id = {enrol}.roleid 
                WHERE {enrol}.courseid =  :courseid
                AND {role}.archetype = :archetype
                ';
        $params = [
            'courseid' => $this->course->id,
            'archetype' => $archetype,
        ];

        return $DB->count_records_sql($sql, $params);
    }
}
