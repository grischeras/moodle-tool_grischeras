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
 * @copyright  2025 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_grischeras\item;

require_once(__DIR__ . '/../../../config.php');

$itemid = required_param('itemid', PARAM_INT);
require_login(null, false);
$context = context_system::instance();
require_capability('tool/grischeras:delete', $context);
$item = (new item('tool_grischeras'))->get_item($itemid);
$indexurl = new moodle_url('/admin/tool/grischeras/index.php', ['id' => $item->courseid]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('edititem', 'tool_grischeras', $itemid));
$PAGE->set_heading(get_string('edititem', 'tool_grischeras', $itemid));
$PAGE->set_url(new moodle_url('/admin/tool/grischeras/deleteconfirmation.php', ['itemid' => $itemid]));
$PAGE->set_secondary_navigation(false);


$item = new item('tool_grischeras');
// Instantiate the myform form from within the plugin.
$deleteform = new \tool_grischeras\form\delete_confirmation_form(
    new moodle_url('/admin/tool/grischeras/delete.php', ['itemid' => $itemid]),
    ['itemid' => $itemid]
);
if ($deleteform->is_submitted()) {
    global $DB;
    $DB->delete_records('tool_grischeras', ['id' => $itemid]);
    redirect($indexurl);
}
$output = $PAGE->get_renderer('tool_grischeras');
echo $output->header();
$deleteform->display();
echo $output->footer();
