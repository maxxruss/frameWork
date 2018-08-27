<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 27.08.2018
 * Time: 18:15
 */

namespace components;

define("DIR_BIG","img/");
define("DIR_SMALL","imgMini/");
define("COLS",3);

use models\Goods;

class Admin
{
    public function adminSave()
    {
        $postInput = new Request();


        $post = $postInput->post();


        if ($post['stickerFit'] == 'on') {
            $post['stickerFit'] = '1';
        } else {
            $post['stickerFit'] = '0';
        };

        if ($post['stickerHit'] == 'on') {
            $post['stickerHit'] = '1';
        } else {
            $post['stickerHit'] = '0';
        };

        $filePath = $_FILES['userfile']['tmp_name'];
        $fileName = $this->translit($_FILES['userfile']['name']);
        $post['bigPhoto'] = DIR_BIG . $fileName;
        $post['miniPhoto'] = DIR_SMALL . $fileName;

        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];
        if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') {
            if ($size > 0 and $size < 1000000) {
                if (copy($filePath, '../public/' . DIR_BIG . $fileName)) {
                    $type = explode('/', $_FILES['userfile']['type'])[1];
                    $this->changeImage(220, 117, '../public/' . DIR_BIG . $fileName, '../public/' . DIR_SMALL . $fileName, $type);

                    //var_dump($post);exit;

                    $goodsModel = new Goods();
                    $goodsModel->update($post);

                    $message = "<h3>Файл успешно загружен на сервер</h3>";
                } else {
                    $message = "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
                    exit;
                }
            } else {
                $message = "<b>Ошибка - картинка превышает 1 Мб.</b>";
            }
        } else {
            $message = "<b>Картинка не подходит по типу! Картинка должна быть в формате JPEG, PNG или GIF</b>";
        }
    }

    public function translit($string)
    {
        $translit = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ы' => 'y', 'ъ' => '', 'ь' => '', 'э' => 'eh', 'ю' => 'yu', 'я' => 'ya');

        return str_replace(' ', '_', strtr(mb_strtolower($string, 'utf-8'), $translit));
    }

    function changeImage($h, $w, $src, $newsrc, $type)
    {
        $newimg = imagecreatetruecolor($h, $w);
        switch ($type) {
            case 'jpeg':
                $img = imagecreatefromjpeg($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagejpeg($newimg, $newsrc);
                break;
            case 'png':
                $img = imagecreatefrompng($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagepng($newimg, $newsrc);
                break;
            case 'gif':
                $img = imagecreatefromgif($src);
                imagecopyresampled($newimg, $img, 0, 0, 0, 0, $h, $w, imagesx($img), imagesy($img));
                imagegif($newimg, $newsrc);
                break;
        }
    }
}