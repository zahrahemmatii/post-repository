<?php

namespace App\Repositories;

use App\Interfaces\PostInterface;
use App\Models\Post;

class PostRepository implements PostInterface
{
    public Post $model;
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function all_items()
    {
        return $this->model::withTrashed()->paginate(10,['id','title','description','image','user_id','created_at','deleted_at']);
    }

    public function get_items()
    {
        return $this->model::paginate(10,['id','title','description','image','user_id','created_at','deleted_at']);
    }

    public function find_item($id)
    {
        return $this->model::findOrFail($id);
    }

    public function find_trash($id)
    {
        return $this->model::withTrashed()->findOrFail($id);
    }

    public function store_item($data)
    {
        return $this->model::create($data);
    }

    public function update_item($data, $id)
    {
        return $this->find_trash($id)->update($data);
    }

    public function restore_item($id)
    {
        return $this->find_trash($id)->restore();
    }

    public function delete_item($id)
    {
        return $this->find_item($id)->delete();
    }
}
