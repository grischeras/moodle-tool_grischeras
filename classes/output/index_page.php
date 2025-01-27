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

use core\exception\coding_exception;
use core_cache\cache;
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

    /**
     * description of the construct method
     *
     * @param string $sometext
     * @param stdClass $course
     */
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
        $data->courseinfos = $this->get_course_details();
        $context = \context_course::instance($this->course->id);
        if (has_capability('tool/grischeras:create', $context)) {
            $buttontxt = get_string('create', 'tool_grischeras');
            $data->insertbutton = $buttontxt;
            $data->insertactionurl = $this->get_action_url('create', ['courseid' => $this->course->id]);
            $data->insertactionfromfile = $this->get_action_url('bulk', ['courseid' => $this->course->id]);
        }
        $data->headers = $this->get_items_headers();
        return $data;
    }

    /**
     * building data array
     * @return array
     * @throws dml_exception
     */
    private function get_course_details(): array {
        return [
            'coursename' => $this->course->fullname,
            'coursename2' => $this->course->fullname,
            'isended' => $this->get_course_status(),
            'infos' => $this->get_course_infos(),
        ];
    }

    /**
     * querying students enrolled in a course
     * @return mixed
     * @throws dml_exception
     */
    private function get_course_infos(): array {
        $records = $this->get_tool_records();
        $results = [];
        foreach ($records as $record) {
            $keyvalues = $this->getkeyvalueresult($record);
            $results[] = $keyvalues;
        }

        return $results;
    }

    /**
     * get tool_grischeras data from db
     *
     * @return mixed
     * @throws dml_exception
     */
    private function get_tool_records(): mixed {
        global $DB;
        $params = [
            'courseid' => $this->course->id,
        ];
        return $DB->get_records('tool_grischeras', $params, 'priority ASC');
    }

    /**
     * creating key value tuples
     *
     * @param stdClass $record
     * @return array
     */
    private function getkeyvalueresult(stdClass $record): array {
        $results = [];
        foreach ($record as $key => $value) {
            $results[] = [
                'value' => $value,
            ];
        }

        return [
            'data' => $results,
            'actions' => $this->get_item_actions(['itemid' => $record->id]),
        ];
    }

    /**
     * Method description.
     *
     * @param array $options
     * @return array
     */
    private function get_item_actions(array $options): array {
        $actions = [];
        $context = \context_course::instance($this->course->id);
        if (has_capability('tool/grischeras:edit', $context)) {
            $actions[] = [
                'type' => 'edit',
                'class' => 'btn-primary',
                'url' => $this->get_action_url('edit', $options),
                'action' => 'edit',
                'id' => $options['itemid'],
            ];
        }
        if (has_capability('tool/grischeras:delete', $context)) {
            $actions[] = [
                'type' => 'delete',
                'class' => 'btn-danger',
                'url' => $this->get_action_url('delete', $options),
                'action' => 'delete',
                'id' => $options['itemid'],
            ];
        }

        return $actions;
    }

    /**
     * Method description.
     *
     * @param string $string
     * @param array $options
     * @return string
     */
    private function get_action_url(string $string, array $options = []): string {

        switch ($string) {
            case 'edit':
                $url = new \moodle_url('/admin/tool/grischeras/edit.php', $options);
                return $url->out(false);
            case 'delete':
                $url = '';
                return $url;
            case 'create':
                $url = new \moodle_url('/admin/tool/grischeras/create.php', $options);
                return $url->out(false);
            case 'bulk':
                $url = new \moodle_url('/admin/tool/grischeras/file_insert.php', $options);
                return $url->out(false);
        }
    }

    /**
     * Method description
     *
     * @return array
     */
    private function get_items_headers(): array {
        $headers = [];
        $records = $this->get_tool_records();
        foreach ($records as $record) {
            foreach ($record as $key => $value) {
                $headers[] = [
                  'key' => $key,
                ];
            }
            break;
        }

        return $headers;
    }

    /**
     * Method description.
     *
     * @return bool
     * @throws coding_exception
     */
    private function get_course_status(): bool
    {
        $cache = cache::make('tool_grischeras', 'coursestatus');
        if(!$cache->get('coursestatus')){
            $cache->set('coursestatus', ($this->course->enddate < time()));
        }

        return $cache->get('coursestatus');
    }
}
