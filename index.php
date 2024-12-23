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
 * a short description of my plugin index
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use tool_grischeras\output\index_page;

require_once(__DIR__ . '/../../../config.php');

require_login(null, false);

// Set up the page.
$title = get_string('pluginname', 'tool_grischeras');
$pagetitle = $title;
$courseid = required_param('id', PARAM_INT);
$url = new moodle_url('/admin/tool/grischeras/index.php', ['id' => $courseid]);

$PAGE->set_context(context_system::instance());

$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);
$course = get_course($courseid);
$PAGE->set_course($course);// Sets up global $COURSE.

// BREADCUMBS.
$previewnode = $PAGE->navigation->add(
    get_string('home'),
    new moodle_url('/index.php'),
    navigation_node::TYPE_CONTAINER
);
$thingnode = $previewnode->add(
    $title,
    $url
);
$thingnode->make_active();
// BREADCUMBS END.

$PAGE->navbar->add(get_string('home'), new moodle_url($url));

// This avoids the site-administration menu to be rendered.
$PAGE->set_secondary_navigation(false);
$PAGE->navbar->add(get_string('home'), new moodle_url($url));

$output = $PAGE->get_renderer('tool_grischeras');
$renderable = new \tool_grischeras\output\index_page('Some demo infos', $course);

echo $output->header();
echo $output->render($renderable);
echo $output->footer();
