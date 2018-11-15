<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:48
 */

namespace components;

define("DIR_BIG","img/");
define("DIR_SMALL","imgMini/");
define("COLS",3);

use models\Goods;

class Model
{
    protected $table = '';
    protected $fields = '';
    protected $rules = '';

    public function getAll($orderby = 'id')
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' order by ' . $orderby);
        //var_dump($statement);exit;
        return $statement->fetchAll();
    }

    public function getOne($id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from ' . $this->table . ' where id = ' . $id);
        return $statement->fetch();
    }

    public function countPlus($id)
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->exec('UPDATE ' . $this->table . ' SET `count`= `count`+1 WHERE id=' . $id);
        return $statement;
    }

    public function countMinus($id)
    {
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->exec('UPDATE ' . $this->table . ' SET `count`= `count`-1 WHERE id=' . $id);
        return $statement;
    }


    public function update($values)
    {
        /**if(!$this->validate($values, $this->rules)) {
         * return false;
         * }**/
        $pdo = Db::getPDO();
        $statement = $pdo->exec('UPDATE `' . $this->table . '` SET nameFull = "' . $values['nameFull'] .
            '", price = ' . $values['price'] . ', param = "' . $values['param'] . '", bigPhoto = "' . $values['bigPhoto'] . '", miniPhoto = "' . $values['miniPhoto'] . '", weight = ' . $values['weight'] . ', stickerFit = "' . $values['stickerFit'] . '", stickerHit = "' . $values['stickerHit'] . '", discount = ' . $values['discount'] . ' WHERE `id` = ' . $values['id']);
               return $statement;
    }

    public function create($values)
    {
        $pdo = DB::getPDO();
        $statement = $pdo->exec("INSERT INTO " . $this->table . " (nameShort, nameFull, price, param, bigPhoto, miniPhoto, weight, stickerFit, stickerHit, discount) VALUES ('" . $values['nameShort'] . "', '" . $values['nameFull'] . "', '" . $values['price'] . "', '" . $values['param'] . "', '" . $values['bigPhoto'] . "', '" . $values['miniPhoto'] . "', '" . $values['weight'] . "', '" . $values['stickerFit'] . "', '" . $values['stickerHit'] . "', '" . $values['discount'] . "')");
        return $statement;
    }

    public function delete($id)
    {
        $pdo = Db::getPDO();
        $statement = $pdo->exec('DELETE from ' . $this->table . ' where id = ' . $id);
        return $statement;
    }

    /**function newComment($fio, $email, $text)
     * {
     * $pdo = DB::getPDO();
     * $pdo->query("INSERT INTO ". $this->table. "(name, description, src, small_src, price) VALUES ('" . $values['name'] . "', '" . $values['description'] ."', '". $values['src'] . "', '" . $values['small_src'] ."', '" . $values['price'] ."')");
     *
     * return true;
     * }**/

    public function validate($values, $rules)
    {
        if (!empty(array_diff_key($values, $rules))) {
            return false;
        }
        foreach ($rules as $key => $rule) {
            if (!isset($values[$key])) {
                continue;
            }
            switch ($rule) {
                case 'string':
                    if (!is_string($values[$key])) {
                        return false;
                    }
                    break;
                case 'int':
                    if (!is_numeric($values[$key])) {
                        return false;
                    }
                    break;
                default:
                    throw new \Exception('Неизвестное правило валидации');
            }
        }
        return true;
    }

    public function edit()
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

        if (empty($_FILES['userfile']['tmp_name'])) {
            $model = new Goods();
            $good = $model->getOneGood($post['id']);
            $post['bigPhoto'] = $good[0]['bigPhoto'];
            $post['miniPhoto'] = $good[0]['miniPhoto'];
            //var_dump($post);exit;
        } else {
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

        $goodsModel = new Goods();
        $goodsModel->update($post);
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
                //echo('ok');exit;
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

    function scanDirLoadFiles()
    {
        $images = array_slice(scandir('../public/loadFiles'), 2);

        foreach ($images as $image) {
            $nameRecodRu = mb_convert_encoding($image, 'UTF-8');

            $nameFull = explode('.', $nameRecodRu)[0];
            $fileName = $this->translit($nameRecodRu);
            $nameShort = explode('.', $fileName)[0];
            $arr['nameShort'] = $nameShort;
            $arr['nameFull'] = $nameFull;
            $arr['price'] = '0';
            $arr['param'] = '0';
            $arr['weight'] = '0';
            $arr['discount'] = '0';
            $arr['stickerFit'] = '0';
            $arr['stickerHit'] = '0';
            $arr['bigPhoto'] = DIR_BIG . $fileName;
            $arr['miniPhoto'] = DIR_SMALL . $fileName;

            if (copy('../public/loadFiles/' . $image, '../public/' . DIR_BIG . $fileName)) {
                //echo('ok');exit;
                $type = explode('.', $fileName)[1];
                $this->changeImage(220, 117, '../public/' . DIR_BIG . $fileName, '../public/' . DIR_SMALL . $fileName, $type);
                $this->create($arr);
            }
        }
    }

}