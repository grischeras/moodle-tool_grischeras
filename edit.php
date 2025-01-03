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
 * @package   tool_dravek
 * @copyright 2018, David <davidmc@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

global $DB;

// If id is passed we get courseid from record on database instead of courseid parameter.
$id = optional_param('id', 0, PARAM_INT);
if ($id) {
    $record = tool_dravek_db::get($id);
    $courseid = $record->courseid;
} else {
    $courseid = optional_param('courseid', 0, PARAM_INT);
    $record = (object)['courseid' => $courseid, 'id' => ''];
}

require_login($courseid);

// Check if they have permission to VIEW.
$context = context_course::instance($courseid);
require_capability('tool/dravek:edit', $context);

// Create URLs.
$url = new moodle_url('/admin/tool/dravek/edit.php', array('courseid' => $courseid));
$urlhome = new moodle_url('/admin/tool/dravek/index.php', ['id' => $courseid]);

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title('Hello to the todo list');
$PAGE->set_heading(get_string('pluginname', 'tool_dravek'));
$PAGE->navbar->add(get_string('edit'), new moodle_url($url));

$mform = new tool_dravek_toolform(null,  array('id' => $record->id));

$textfieldoptions = array('trusttext' => true,
                            'subdirs' => true,
                            'maxfiles' => 50,
                            'maxbytes' => 0,
                            'context' => $context,
                            'noclean' => 0,
                            'enable_filemanagement' => true);
if ($record->id) {
    $context = context_course::instance($record->courseid);
    file_prepare_standard_editor($record, 'description', $textfieldoptions, $context, 'tool_dravek', 'comments', $record->id);
}
$mform->set_data($record);

// Process Form data.
if ($mform->is_cancelled()) {
    redirect($urlhome);
} else if ($data = $mform->get_data()) {

    if (!empty($data->id)) {
        tool_dravek_db::update($data);
    } else {
        tool_dravek_db::insert($data);
    }
    redirect($urlhome);
}

// Display.
echo $OUTPUT->header();
$mform->display();
echo html_writer::link($urlhome, get_string('home', 'tool_dravek'));
echo $OUTPUT->footer();