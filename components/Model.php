<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:52
 */

namespace components;

use components\Interfaces\Query;
use components\Db;

class Model implements Query
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
        $statement = $pdo->query('select * from '. $this->table.' where '. $parameters = ['where'].' orderby '.$parameters = ['orderby'].' limit '.$parameters = ['limit']);

        return $statement->fetchAll();
    }

    public function getAll() {

        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from '. $this->table );
        return $statement->fetchAll();
    }

    public function getOne($id) {

        $pdo = Db::getPDO();
        $statement = $pdo->query('select * from '. $this->table .' where id = ' . $id);
        $result = $statement->fetchAll();

        return empty($result[0]) ? null : $result[0];
    }

    public function update($id, $values) {

        if(!$this->validate($values, $this->rules)) {
            return false;
        }


        $pdo = Db::getPDO();
        $statement = $pdo->query(" UPDATE ". $this->table ." SET title = " . $values['title'] .",  content = ".$values['content']." where id = " . $id);
        //$result = $statement->fetchAll();
        //return empty($result[0]) ? null : $result[0];

        return $statement;
    }

    public function create($values) {
        print_r($values);

        /**if(!$this->validate($values, $this->rules)) {
            echo 'не работает';
            return false;
        } **/

        $pdo = DB::getPDO();

        echo('<pre>');
        var_dump($values);
        echo('</pre>');

        $pdo->query("INSERT INTO `blogs` (`title`, `content`) VALUES ('" .
            $values['title'] . "', '" . $values['content'] . "')");

        /**INSERT INTO old_links (id,id_user,link) VALUES (1,1,'ya.ru')
        $query = 'insert into ' . $this->table . ' (';
        $query .= implode(', ', array_keys($values)) . ') values ( :';
        $query .= implode(', :',array_keys($values)) . ')';

        $statement = $pdo->prepare($query);**/

        return true;

    }

    public function delete($id) {
        $pdo = Db::getPDO();
        $pdo->query('DELETE * from '. $this->table .' where id = ' . $id);
        return true;
    }


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
}