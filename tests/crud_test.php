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

namespace tests;

use advanced_testcase;
use stdClass;
use tool_grischeras\item;

/**
 * Class description.
 */
final class crud_test extends advanced_testcase {

    /**
     * Test insertion of a new item.
     */
    public function test_insert_item(): void {
        $this->resetAfterTest();
        $item = new item('tool_grischeras');
        $data = new stdClass();
        $data->name = 'test';
        $data->priority = 5;
        $data->completed = true;
        $insertid = $item->insert_item($data);
        $insertedobject = $item->get_item($insertid);
        $this->assertTrue(!empty($insertedobject->id));
        $this->assertInstanceOf(StdClass::class, $insertedobject);
    }

    /**
     * Test update of an inserted item.
     */
    public function test_update_item(): void {
        $this->resetAfterTest();
        $item = new item('tool_grischeras');
        $data = new stdClass();
        $data->name = 'test';
        $data->priority = 5;
        $data->completed = true;
        $insertid = $item->insert_item($data);
        $insertedobject = $item->get_item($insertid);
        $this->assertTrue(!empty($insertedobject->id));
        $this->assertInstanceOf(StdClass::class, $insertedobject);
        $data->name = 'test modified';
        $item->update_item($insertid, $data);
        $updatedobject = $item->get_item($insertid);
        $this->assertEquals('test modified', $updatedobject->name);
    }
    /**
     * Test deletion of an inserted item.
     */
    public function test_delete_item(): void {
        $this->resetAfterTest();
        $item = new item('tool_grischeras');
        $data = new stdClass();
        $data->name = 'test';
        $data->priority = 5;
        $data->completed = true;
        $insertid = $item->insert_item($data);
        $insertedobject = $item->get_item($insertid);
        $this->assertTrue(!empty($insertedobject->id));
        $this->assertInstanceOf(StdClass::class, $insertedobject);
        $item->delete_item($insertid);
        $deletedobject = $item->get_item($insertid);
        $this->assertNull($deletedobject);
    }

}
