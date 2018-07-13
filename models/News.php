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

    public function selectNews(array $parameters) {
        return $this->select(array ($parameters));
    }

    public function createNews(array $values) {
        return $this->create(array ($values));
    }

    public function updateNews($id, array $values) {
        return $this->update($id, array ($values));
    }

    public function deleteNews($id) {
        return $this->delete($id);
    }
}
