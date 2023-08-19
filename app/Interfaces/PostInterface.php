<?php

namespace App\Interfaces;

interface PostInterface
{
    public function all_items();
    public function get_items();
    public function find_item($id);
    public function find_trash($id);
    public function store_item(array $data);
    public function update_item(array $data,$id);
    public function delete_item($id);
    public function restore_item($id);
}
