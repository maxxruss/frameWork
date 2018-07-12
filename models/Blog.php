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

    public function getOneBlog($id) {
        return $this->getOne($id);
    }
}
