<?php

function get_connection()
{
    $data = array(
        'server' => 'locahost',
        'database' => 'Film',
        'username' => 'SA',
        'password' => 'abcd',
    );
    $con = mysqli_connect('localhost', 'SA', 'abcd', 'Film');
    return $con;
}

function getData()
{
    $con = get_connection();
    if (!$con) {
        return null;
    } else {
        $query = 'SELECT * FROM Movie ORDER BY PRICE ASC limit 3 ';
        $res =  mysqli_query($con, $query);
        return $res;
    }
}


//  =============== nomor 2

$data = $_POST['str_user'];
$data = 12345;
if (strlen($data) != 9) {
}
