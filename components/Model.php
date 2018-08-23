<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 15:48
 */

namespace components;

use components\Interfaces\Query;
use components\Db;

class Model //implements Query
{
    protected $table = '';
    protected $fields = '';
    protected $rules = '';

    public function select($parameters) {
        $parameters = [
            'where' => 'id = 1',
            'orderby' => 'desc',
            'limit ' => ' 1,10 '
        ];
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from '. $this->table . ' where ' . $parameters = ['where'].' orderby '.$parameters = ['orderby'].' limit '.$parameters = ['limit']);
        return $statement->fetchAll();
    }
    public function getAll($orderby = 'id') {
        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from '. $this->table);
        return $statement->fetchAll();
    }
    public function getOne($id) {
        //echo $id; exit;
        $pdo = Db::getPDO();
        //var_dump($pdo);exit;
        $statement = $pdo->query('select * from '. $this->table .' where id = ' . $id);
        $result = $statement->fetchAll();
        return empty($result[0]) ? null : $result[0];
    }
    public function update($values) {
        /**if(!$this->validate($values, $this->rules)) {
        return false;
        }**/
        $pdo = Db::getPDO();
        $statement = $pdo->query("UPDATE `" . $this->table .
            "` SET `name` = '" . $values['name'] .
            "', `description` = '" . $values['description'] . "` SET `src` = '" . $values['src'] . "` SET `small_src` = '" . $values['small_src'] . "` SET `price` = '" . $values['price'] ."' WHERE `id` = '" . $values['id'] . "'");
        //var_dump($statement);
        //$result = $statement->fetchAll();
        //return empty($result[0]) ? null : $result[0];
        return $statement;
    }
    public function create($values) {
        /**if(!$this->validate($values, $this->rules)) {
        echo 'не работает';
        return false;
        } **/
        $pdo = DB::getPDO();
        $pdo->query("INSERT INTO ". $this->table. "(name, description, src, small_src, price) VALUES ('" . $values['name'] . "', '" . $values['description'] ."', '". $values['src'] . "', '" . $values['small_src'] ."', '" . $values['price'] ."')");
        /**INSERT INTO old_links (id,id_user,link) VALUES (1,1,'ya.ru')
        $query = 'insert into ' . $this->table . ' (';
        $query .= implode(', ', array_keys($values)) . ') values ( :';
        $query .= implode(', :',array_keys($values)) . ')';
        $statement = $pdo->prepare($query);**/
        return true;
    }
    public function delete($id) {
        $pdo = Db::getPDO();
        $pdo->query('DELETE from '. $this->table .' where id = ' . $id);
        return true;
    }

    /**function newComment($fio, $email, $text)
    {
        $pdo = DB::getPDO();
        $pdo->query("INSERT INTO ". $this->table. "(name, description, src, small_src, price) VALUES ('" . $values['name'] . "', '" . $values['description'] ."', '". $values['src'] . "', '" . $values['small_src'] ."', '" . $values['price'] ."')");

        return true;
    }**/

    public function validate($values, $rules) {
        if(!empty(array_diff_key($values, $rules))) {
            return false;
        }
        foreach ($rules as $key => $rule) {
            if(!isset($values[$key])) {
                continue;
            }
            switch($rule) {
                case 'string':
                    if(!is_string($values[$key])) {
                        return false;
                    }
                    break;
                case 'int':
                    if(!is_numeric($values[$key])) {
                        return false;
                    }
                    break;
                default:
                    throw new \Exception('Неизвестное правило валидации');
            }
        }
        return true;
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

    public function changeImage($h, $w, $src, $newsrc, $type)
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

    function scanDirLoadFiles () {

        $images = array_slice(scandir('../public/loadFiles'), 2);

        foreach ($images as $image) {
            $nameRecodRu = iconv("cp1251", "UTF-8", $image);
            $nameFull = explode('.', $nameRecodRu)[0];
            $fileName = $this->translit($nameRecodRu);
            $nameShort = explode('.', $fileName)[0];
            $arr[] = $fileName;

            if (copy('../public/loadFiles/' . $image, '../public/' . DIR_BIG . $fileName)) {
                $type = explode('.', $fileName)[1];
                $this->changeImage(220, 117, '../public/' . DIR_BIG . $fileName, '../public/' . DIR_SMALL . $fileName, $type);
                goods_new($connect, $nameShort, $nameFull, $price, $param, DIR_BIG . $fileName, DIR_SMALL . $fileName);
            }
        }
    }
}