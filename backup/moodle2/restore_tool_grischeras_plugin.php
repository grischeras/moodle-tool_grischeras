<?php

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/backup/moodle2/restore_tool_plugin.class.php');
class restore_tool_grischeras_plugin extends restore_tool_plugin {

    protected function define_course_plugin_structure() {
        $paths = array();
        $paths[] = new restore_path_element('tool_grischeras', '/course/tool_grischeras');
        return $paths;
    }

    public function process_tool_grischeras($data) {
        global $DB;
        $data = (object) $data;
        // Store the old id.
        $oldid = $data->id;
        // Change the values before we insert it.
        $data->courseid = $this->task->get_courseid();
        $data->timecreated = time();
        $data->timemodified = $data->timecreated;
        // Now we can insert the new record.
        $data->id = $DB->insert_record('tool_grischeras', $data);
        // Set up the mapping.
        $this->set_mapping('tool_grischeras', $oldid, $data->id);

        $this->add_related_files('tool_grischeras', 'comments', null);
    }
}
