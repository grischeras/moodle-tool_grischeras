<?php

namespace tool_grischeras\external;

use context_course;
use core_external\external_function_parameters;
use core_external\external_value;
use tool_grischeras\item;

class edit_item extends \core_external\external_api {
    /**
     * Get the function parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'itemid' => new external_value(PARAM_INT, 'The id of the item to edit'),
            'name' => new external_value(PARAM_RAW, 'name of the item to edit'),
            'completed' => new external_value(PARAM_RAW, 'if the item to edit is completed'),
            'priority' => new external_value(PARAM_INT, 'priority of the item to edit'),
        ]);
    }


    /**
     * Method description.
     *
     * @param int $itemid
     * @param string $name
     * @param bool $completed
     * @param int $priority
     * @return void
     */
    public static function execute(int $itemid, string $name, bool $completed, int $priority): void {

        self::validate_parameters(self::execute_parameters(), [
            'itemid' => $itemid,
            'name' => $name,
            'completed' => $completed,
            'priority' => $priority,
        ]);
        $item = new item('tool_grischeras');
        $courseid = $item->get_item($itemid)->courseid;
        self::validate_context(context_course::instance($courseid));
        $object = new \stdClass();
        $object->name = $name;
        $object->priority = $priority;
        $object->completed = $completed;
        $item->update_item($itemid, $object);
    }

    /**
     * We don't need to return anything.
     */
    public static function execute_returns() {
        return null;
    }
}