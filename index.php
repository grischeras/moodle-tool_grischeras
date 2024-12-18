<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');


admin_externalpage_setup('toolgrischeras');
// Set up the page.
$title = get_string('pluginname', 'tool_grischeras');
$pagetitle = $title;

$url = new moodle_url('/admin/tool/grischeras/index.php');

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

$output = $PAGE->get_renderer('tool_grischeras');


echo $output->header();
echo $output->heading($pagetitle);

$renderable = new \tool_demo\output\index_page('Some text');
echo $output->render($renderable);

echo $output->footer();