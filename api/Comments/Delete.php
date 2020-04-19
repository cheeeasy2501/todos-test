<?php
require '../config.php';

switch ($method) {
    case 'POST':
        if(empty($_POST))
        {
            $_POST = $jsonPost;
        }
        $deleteId = (int)$_POST["deleteId"];
        $sql = "DELETE FROM comments WHERE comments.id=".$deleteId;
        break;
}

// run SQL statement
$result = mysqli_query($connect,$sql);
// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error($connect));
}