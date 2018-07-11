<?php

namespace models;

use components\Model;

class News extends Model
{
    public function getNews()
    {
        return [
            [
                'id' => 1,
                'title' => 'Первая новость',
                'content' => 'Содержание первой записи новости',
            ],
            [
                'id' => 2,
                'title' => 'Вторая новость',
                'content' => 'Содержание втрой записи новости',
            ],
            [
                'id' => 3,
                'title' => 'Третья новость',
                'content' => 'Содержание тртьей записи новости',
            ],

        ];
    }

    public function getOneNews($id)
    {
        return [
                    'id' => 1,
                    'title' => 'Первая новость',
                    'content' => 'Содержание первой записи новости',
                ];
    }
}
