<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "tododb";
$id = '';

$connect = mysqli_connect($host, $user, $password,$dbname);

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$jsonPost = json_decode(file_get_contents('php://input'),true);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}