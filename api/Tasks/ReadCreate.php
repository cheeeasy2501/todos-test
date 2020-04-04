<?php
require '../config.php';

switch ($method) {
    case 'GET':
        $sql = "
        SELECT a.id,a.task,a.description,(SELECT status_value FROM `tag` t WHERE a.status=t.status_id) AS status, 
        GROUP_CONCAT(b.comment ORDER BY b.comment DESC SEPARATOR '| ') AS comments
                FROM `tasks` a
                LEFT JOIN `comments` b ON a.id=b.tasks_id
                GROUP BY a.id";
         break;
    case 'POST':
        if(empty($_POST))
        {
            $_POST = $jsonPost;
        }
        $task = $_POST["task"];
        $description = $_POST["description"];
        $status = (int)$_POST["status"];
        $sql = "insert into tasks (task, description, status) values ('$task', '$description', '$status')";
        break;
}

// run SQL statement
$result = mysqli_query($connect,$sql);
// die if SQL statement failed
if (!$result) {
    http_response_code(404);
    die(mysqli_error($connect));
}

if ($method == 'GET') {
    if (!$id) echo '[';
    for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
        echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
    }
    if (!$id) echo ']';
} elseif ($method == 'POST') {
    echo json_encode($result);
} else {
    echo mysqli_affected_rows($connect);
}