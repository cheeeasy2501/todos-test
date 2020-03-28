<?php
require '../config.php';

switch ($method) {
    case 'POST':
        if(empty($_POST))
        {
            $_POST = $jsonPost;
        }
        $max_query="SELECT MAX(ID) as max_id FROM comments";
        $max_sql = mysqli_query($connect,$max_query);
        $row = mysqli_fetch_assoc($max_sql);
        $maxId = (int)$row['max_id']+1;
        $task_id = (int)$_POST["task_id"];
        $comment = json_encode((object) array('content' => $_POST['content'],'id' => $maxId));
        $sql = "insert into comments (tasks_id, comment) values ('$task_id', '$comment')";
        break;
}

// run SQL statement
$result = mysqli_query($connect,$sql);
// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error($connect));
}

if ($method == 'POST') {
    $result= $maxId;
    echo json_encode($result);
}