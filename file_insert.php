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
 * @copyright  2025 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_grischeras\form;

use context_course;
use moodle_url;
use moodleform;
use stdClass;use tool_grischeras\item;

require_once(__DIR__ . '/../../../config.php');

// If id is passed we get record id on database instead of courseid parameter.
require_login(null, false);
$courseid = required_param('courseid', PARAM_INT);
$context = context_course::instance($courseid);
require_capability('tool/grischeras:create', $context);
$PAGE->set_context($context);
$indexurl = new moodle_url('/admin/tool/grischeras/index.php', ['id' => $courseid]);
$PAGE->set_url($indexurl);
$PAGE->set_context($context);
$PAGE->set_title(get_string('create', 'tool_grischeras'));
$PAGE->set_heading(get_string('create', 'tool_grischeras'));
$PAGE->set_secondary_navigation(false);


$item = new item('tool_grischeras');
// Instantiate the myform form from within the plugin.
$fileform = new \tool_grischeras\form\file_insert_form(
    '',
    ['courseid' => $courseid]);


if ($fileform->is_cancelled()) {
    redirect(new moodle_url('/admin/tool/grischeras', ['id' => $courseid]));
}
$data = $fileform->get_data();
if (!empty($data)) {
    $item = new item('tool_grischeras');
    $filecontent = $fileform->get_file_content('userfile');
    $records = explode("\n", $filecontent);
    unset($records[0]);
    $records = array_filter($records);
    foreach ($records as $record) {
        $singlevalue = explode(";", $record);
        $newitem = new stdClass();
        $newitem->name = $singlevalue[0];
        $newitem->priority = (int)$singlevalue[1];
        $newitem->completed = (bool)$singlevalue[2];
        $newitem->courseid = $courseid;
        $item->insert_if_not_exists($newitem);
    }
    redirect(new moodle_url('/admin/tool/grischeras', ['id' => $courseid]));
}

$output = $PAGE->get_renderer('tool_grischeras');
echo $output->header();
$fileform->display();
echo $output->footer();
