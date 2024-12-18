<?php declare(strict_types = 1);

namespace tool_grischeras\output;

use renderable;
use renderer_base;
use templatable;
use stdClass;

class index_page implements renderable, templatable {
    /** @var string $sometext Some text to show how to pass data to a template. */
    private $sometext = null;

    public function __construct($sometext) {
        $this->sometext = $sometext;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @return stdClass
     */
    public function export_for_template(renderer_base $output): stdClass {
        $data = new stdClass();
        $data->sometext = $this->sometext;
        $data->infos = [
            ['key' => 'information', 'value' => 'string 1'],
            ['key' => 'another info', 'value' => 'string 2'],
            ['key' => 'additional example for mustache', 'value' => 'string 3']
        ];

        return $data;
    }
}