<?php
require '../../config.php';

switch ($method) {
    case 'POST':
        if(empty($_POST))
        {
            $_POST = $jsonPost;
        }
        $updateId = (int)$_POST["updateId"];
        $status = (int)$_POST['status'];
        $sql = "UPDATE tasks SET status='".$status."'  WHERE tasks.id=".$updateId;
        break;
}

// run SQL statement
$result = mysqli_query($connect,$sql);
// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error($connect));
}