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
 * a short description of my plugin edit
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_grischeras\item;

require_once(__DIR__ . '/../../../config.php');

// If id is passed we get courseid from record on database instead of courseid parameter.
$itemid = required_param('itemid', PARAM_INT);
require_login(null, false);

// Check if they have permission to VIEW.
$context = context_system::instance();
require_capability('tool/grischeras:edit', $context);
$PAGE->set_context($context);
$PAGE->set_title(get_string('edititem', 'tool_grischeras', $itemid));
$PAGE->set_heading(get_string('edititem', 'tool_grischeras', $itemid));
$PAGE->set_url(new moodle_url('/admin/tool/grischeras/edititem.php', ['itemid' => $itemid]));
$PAGE->set_secondary_navigation(false);


$item = new item('tool_grischeras');
// Instantiate the myform form from within the plugin.
$editform = new \tool_grischeras\form\edit_item_form(new moodle_url('/admin/tool/grischeras/edit.php', ['itemid' => $itemid]), ['itemid' => $itemid]);
if($editform->is_cancelled()) {
    $item = $item->get_item($itemid);
    redirect(new moodle_url('/admin/tool/grischeras', ['id' => $item->courseid]));
}

$data = $editform->get_data();
if(!empty($data)) {
    $item = $item->update_item($itemid, $data);
    redirect(new moodle_url('/admin/tool/grischeras', ['id' => $item->courseid]));
}

$output = $PAGE->get_renderer('tool_grischeras');
echo $output->header();
$editform->display();
echo $output->footer();



