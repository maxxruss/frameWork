<?php

namespace models;

use components\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fields = [
        'id',
        'title',
        'content'
    ];

    public $rules = [
        'id'     => 'int',
        'title'  => 'string',
        'content' => 'string'
    ];

    public function getBlogs() {
        return $this->getAll();
    }

    public function getOneBlogs($id) {
        return $this->getOne($id);
    }

    public function selectBlogs($parameters) {
        return $this->select(($parameters));
    }

    public function createBlogs($values) {
        return $this->create($values);
    }

    public function updateBlogs($values) {
        return $this->update($values);
    }

    public function deleteBlogs($id) {
        return $this->delete($id);
    }
}
