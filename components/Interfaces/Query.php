<?php
/**
 * Created by PhpStorm.
 * User: максим
 * Date: 23.08.2018
 * Time: 17:25
 */

namespace components\Interfaces;
interface Query
{
    public function select($parameters);
    public function getAll();
    public function getOne($id);
    public function update($values);
    public function create($values);
    public function delete($id);
    public function validate($values, $rules);
}