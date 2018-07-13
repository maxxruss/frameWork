<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 13.07.2018
 * Time: 14:49
 */

namespace components\Interfaces;

interface Query
{
    public function select($parameters);
    public function getAll();
    public function getOne($id);
    public function update($id, $values);
    public function create($values);
    public function delete($id);
    public function validate($values, $rules);
}