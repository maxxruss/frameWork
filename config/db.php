<?php

function get_connection() {
    static $connection = null;
    if(!empty($connection)) {
        return $connection;
    }
    $config = require CONFIG_DIR . "db.php";
    $connection = mysqli_connect(
        $config['server'],
        $config['login'],
        $config['pass'],
        $config['database']
    );
    mysqli_set_charset ($connection , 'utf8');
    return $connection;
}

function executeQuery($sql) {
    $connection = get_connection();
    return mysqli_query($connection, $sql);
}

function getAssocResult($sql) {
    $connection = get_connection();
    $result = mysqli_query($connection,$sql);
    $array = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function getGoodsResult($sql) {
    $connection = get_connection();
	$result = mysqli_fetch_assoc(mysqli_query($connection,$sql));
    return $result;
}

function getAssocResultOne($sql) {
    $connection = get_connection();
    $result = mysqli_query($connection,$sql);
    return mysqli_fetch_assoc($result);
}

?>