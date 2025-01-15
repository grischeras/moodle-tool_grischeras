<?php

namespace tool_grischeras\external;

use context_system;
use \core_external\external_function_parameters;
use \core_external\external_value;
use tool_grischeras\item;

/**
 * Class description.
 */
class delete_item extends \core_external\external_api
{
    /**
     * Get the function parameters.
     *
     * @return external_function_parameters
     */
    public static function execute_parameters(): external_function_parameters {
        return new external_function_parameters([
            'itemId' => new external_value(PARAM_INT, 'The id of the item to delete'),
        ]);
    }

    /**
     * Method description
     *
     * @param int $itemId
     * @return void
     */
    public static function execute(int $itemId): void {
        self::validate_context(context_system::instance());
        self::validate_parameters(self::execute_parameters(), ['itemId' => $itemId]);
        $item = new item('tool_grischeras');
        $item->delete_item($itemId);
    }

    /**
     * We don't need to return anything.
     */
    public static function execute_returns() {
        return null;
    }
}
