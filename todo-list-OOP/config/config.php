<?php 
foreach (glob("validation/*.php") as $filename) {
    require_once $filename;
}
require_once('config/session_messages.php');
require_once('config/printSessionMessage.php');
// dataBase default values
$_SESSION['user']=array(
    'name'=>"",
    'user_name'=>"",
    'password'=>"",
    'confirm_password'=>'',
    'deleted_tasks'=>""
);
$_SESSION['task']=array(
    'name'=>"",
    'start_date'=>date('Y-m-d'),
    'end_date'=>date('Y-m-d'),
    'status'=>'',
    'user_id'=>0
);

?>