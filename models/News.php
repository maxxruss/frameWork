<?php

namespace models;

use components\Model;

class News extends Model
{
    protected $table = 'news';

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

    public function getNews() {
        return $this->getAll();
    }

    public function getOneNews($id) {
        return $this->getOne($id);
    }

    public function selectNews($parameters) {
        return $this->select($parameters);
    }

    public function createNews($values) {
        return $this->create($values);
    }

    public function updateNews($values) {
        return $this->update($values);
    }

    public function deleteNews($id) {
        return $this->delete($id);
    }
}
