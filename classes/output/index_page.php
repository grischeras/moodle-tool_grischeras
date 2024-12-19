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
 * a short description about index_page
 * @package    tool_grischeras
 * @copyright  2024 Alberto Sempreboni
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types = 1);

namespace tool_grischeras\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;

/**
 * The class to render plugin's index page
 * @package    tool_grischeras
 */
class index_page implements renderable, templatable {

    /** @var string|null
     * $sometext Some text to show how to pass data to a template.
     */
    private string|null $sometext = null;

    /**
     * short description of constructor
     * @param string $sometext
     */
    public function __construct(string $sometext) {
        $this->sometext = $sometext;
    }

    /**
     * a short description for this method
     * @param renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->sometext = $this->sometext;
        $data->infos = [
            ['key' => 'information', 'value' => 'string 1'],
            ['key' => 'another info', 'value' => 'string 2'],
            ['key' => 'additional example for mustache', 'value' => 'string 3'],
        ];

        return $data;
    }
}
