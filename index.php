<?php

require_once(__DIR__ . '/../../../config.php');

require_login(null, false);

// Set up the page.
$title = get_string('pluginname', 'tool_grischeras');
$pagetitle = $title;

$url = new moodle_url('/admin/tool/grischeras/index.php');

/** BREADCUMBS*/
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
/** BREADCUMBS END */

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_title($title);
$PAGE->set_heading($title);

$output = $PAGE->get_renderer('tool_grischeras');
$renderable = new \tool_grischeras\output\index_page('Some demo infos');

echo $output->header();
echo $output->render($renderable);
echo $output->footer();
