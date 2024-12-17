<?php

require_once(__DIR__ . '/../../../config.php');
$url = new moodle_url('/admin/tool/grischeras/index.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title('Hello to My Plugin!');
$PAGE->set_heading(get_string('pluginname', 'tool_grischeras'));

echo  get_string('pluginname', 'tool_grischeras');