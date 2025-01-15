<?php

namespace tool_grischeras\external;

use coding_exception;
use context_system;
use external_api;
use external_function_parameters;
use external_value;
use tool_grischeras\item;

class delete_item extends external_api
{
    /**
     * Get the function parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'itemId' => new external_value(PARAM_INT, 'The id for the item to enter'),
        ]);
    }

    /**
     * Method description.
     *
     * @param int $itemid
     */
    public static function execute(int $itemid): void {
        self::validate_context(context_system::instance());
        $params = self::validate_parameters(self::execute_parameters(), ['itemId' => $itemid]);
        $item = new item('tool_grischeras');
        $item = $item->get_item($itemid);
        $item->delete();
    }

    /**
     * We don't need to return anything.
     */
    public static function execute_returns() {
        return null;
    }
}