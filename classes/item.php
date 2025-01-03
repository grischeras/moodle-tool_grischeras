<?php

namespace tool_grischeras;

use tool_grischeras\database;
class item extends database {
    /**
     * @param string $table
     */
    public function __construct(string $table) {
        $this->table = $table;
    }

    /**
     * @param int $id
     * @return object
     */
    public function get_item(int $id): object {
        $this->get_one_by_id($id);
        return  $this->item;
    }

    /**
     * @param int $id
     * @param \stdClass $data
     * @return object
     */
    public function update_item(int $id, \stdClass $data): object {
        $this->get_item($id);
        $this->item->name = $data->name;
        $this->item->priority = $data->priority;
        $this->item->completed = $data->completed;
        $this->save();

        return $this->item;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete_item(int $id): bool {
        $this->get_item($id);

        return $this->delete();
    }
}
