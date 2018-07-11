<?php

namespace models;

use components\Model;

class Blog extends Model
{
    public function getBlogs()
    {
        return [
            [
                'id' => 1,
                'title' => 'Первый блог',
                'content' => 'Содержание первой записи блога',
            ],
            [
                'id' => 2,
                'title' => 'Второй блог',
                'content' => 'Содержание втрой записи блога',
            ],
            [
                'id' => 3,
                'title' => 'Третий блог',
                'content' => 'Содержание тртьей записи блога',
            ],

        ];
    }

    public function getBlog($id)
    {
        return [
                    'id' => 1,
                    'title' => 'Первый блог',
                    'content' => 'Содержание первой записи блога',
                ];
    }
}
