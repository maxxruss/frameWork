<?php
/**
 * Created by PhpStorm.
 * User: alterwalker
 * Date: 21.05.2018
 * Time: 19:52
 */

namespace components;

class Model
{
    protected $table = '';
    protected $fields = '';
    protected $rules = '';

    public function select($closure = []) {

        /*
         $closure = [
            'where' => 'id >3 and name like %vasy%',
            'orderby' => 'desc',
            'limit ' => ' 1,10 '
         ]

            // TODO: implement me
         */

        $pdo = Db::getPDO();

        $statement = $pdo->query('select * from '. $this->table );

        return $statement->fetchAll();
    }

    public function getAll() {
        $pdo = Db::getPDO();

        $statement = $pdo->query('select * from '. $this->table );

        return $statement->fetchAll();
    }

    public function getOne($id) {
        $pdo = Db::getPDO();

        $statement = $pdo->query('select * from '. $this->table .' where id = ' . $id .' limit 1');
        $result = $statement->fetchAll();

        return empty($result[0]) ? null : $result[0];
    }

    public function update($id, $values) {
        // TODO: implement me
    }

    public function create($values) {

        if(!$this->validate($values, $this->rules)) {
            return false;
        }

        $pdo = DB::getPDO();
        //INSERT INTO old_links (id,id_user,link) VALUES (1,1,'ya.ru')
        $query = 'insert into ' . $this->table . ' (';
        $query .= implode(', ', array_keys($values)) . ') values ( :';
        $query .= implode(', :',array_keys($values)) . ')';

        $statement = $pdo->prepare($query);

        return $statement->execute($values);

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