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
 * a short description about services
 *
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


use tool_grischeras\external\delete;
use tool_grischeras\external\edit_item;

defined('MOODLE_INTERNAL') || die();

$functions = [
    'tool_grischeras_delete' => [
        'classname' => delete::class,
        'description' => 'Delete the selected item.',
        'type' => 'write',
        'ajax' => true,
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
    'tool_grischeras_edit' => [
        'classname' => edit_item::class,
        'description' => 'Edit the selected item.',
        'type' => 'write',
        'ajax' => true,
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE],
    ],
];
