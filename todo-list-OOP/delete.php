<?php
$conn = require_once('config/connection.php');
if (isset($_GET['user_id'])&&isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id=$_GET['user_id'];
    // i want number of deleted tasks
    $data=$conn->getData('user','id',"id=$user_id")[0];
    // print_r($data);
    $data['deleted_tasks']++;
    $conn->updateUser($data);
    $conn->remove('task',$id);
    header('LOCATION:'.SITEURL);
}

?>