<?php

$observers = [
    [
        'eventname'   => '\tool_grischeras\event\delete_item_event',
        'callback'    => \tool_grischeras\grischeras_observer::class.'::delete_item()',
    ],
];