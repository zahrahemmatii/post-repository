<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    private User $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function all_items()
    {
        return $this->model::withTrashed()->paginate(10,
            ['id','full_name','email','mobile','role_id','deleted_at','created_at']);
    }

    public function get_items()
    {
        return $this->model::
        paginate(10,['id','full_name','email','mobile','role_id','deleted_at','created_at']);

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

    public function find_by_username($mobile)
    {
        return $this->model::where('mobile','=',$mobile)->firstOrFail();
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
