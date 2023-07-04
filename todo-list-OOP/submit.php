<?php
require_once('config/config.php');
$GLOBALS['conn'] = require_once('config/connection.php');
function submit($data, $tablename, $type)
{
    foreach ($_SESSION["$tablename"] as $key => $value) {
        if (isset($_SESSION["$key"]))
            unset($_SESSION["$key"]);
        if (!isset($data["$key"])) {
            $data["$key"] = $value;
        }
        if ($key == 'name' || $key == 'user_name' || $key == 'status') {
            $data["$key"] = string_validation($GLOBALS['conn']->mysqli, $data["$key"], $key);
        } else if ($key == 'start_date' || $key == 'end_date') {
            date_vallidation($data["$key"]);
        } else if ($key == 'id' || $key == 'user_id' || $key == 'deleted_tasks') {
            $data["$key"] = number_validation($GLOBALS['conn']->mysqli, $data["$key"], $key);
        } else if ($key == 'password' || $key == 'confirm_password') {
            $data["$key"] = password_validation($GLOBALS['conn']->mysqli, $data["$key"], $key);
            $data["$key"] = md5($data["$key"]);
        }
    }
    if ($tablename == 'user') {
        if (($type == 'add' || $type == 'update') && $_POST['password'] != $_POST['confirm_password']) {
            $_SESSION['confirm_password'] = 'Password not match';
        }
        if (($type == 'add' || $type == 'update')) {
            if (!isset($_SESSION['name']) && !isset($_SESSION['user_name']) && !isset($_SESSION['password']) && !isset($_SESSION['confirm_password'])) {
                if ($GLOBALS['conn'] instanceof Connection) {
                    if ($type == 'add') {
                        $GLOBALS['conn']->adduser($data);
                    } else if ($type == 'update') {
                        $GLOBALS['conn']->updateUser($data);
                    }
                    header('location:' . SITEURL . 'login.php');
                } else {
                    $message = "Error in the connection with database, try to call the admin of the page!!";
                    Message('error', $message, 'database');
                }
            } else {
                header('location:' . SITEURL . 'register.php');
            }
        } else if ($type == 'login' && !isset($_SESSION['user_name']) && !isset($_SESSION['password'])) {
            if ($GLOBALS['conn'] instanceof Connection) {
                if ($type == 'login') {
                    $user_name = $_POST['user_name'];
                    $password = $_POST['password'];
                    $data = $GLOBALS['conn']->getData('user', 'id', "user_name='$user_name' AND password='$password'");
                    if (count($data) > 0) {
                        $_SESSION['id'] = $data[0]['id'];
                        if (isset($_SESSION['id']))
                            header('location:' . SITEURL);
                        else {
                            Message('error', 'Error!!', 'database');
                            header('location:' . SITEURL . 'login.php');
                        }
                    } else {
                        Message('error', 'Username or password is not valid!!', 'database');
                        header('location:' . SITEURL . 'login.php');
                    }
                }
            } else {
                $message = "Error in the connection with database, try to call the admin of the page!!";
                Message('error', $message, 'database');
            }
        } else {
            header('location:' . SITEURL . 'login.php');
        }
    } else {
        if (!isset($_SESSION['name']) && !isset($_SESSION['start_date']) && !isset($_SESSION['end_date'])) {
            if ($GLOBALS['conn'] instanceof Connection) {
                if ($type == 'add') {
                    $GLOBALS['conn']->addTask($data);
                } else if ($type == 'update') {
                    $GLOBALS['conn']->updateTask($data);
                }
            } else {
                $message = "Error in the connection with database, try to call the admin of the page!!";
                Message('error', $message, 'database');
            }
            header('location:' . SITEURL . 'userpage.php');
        } else {
            if ($type == 'update') {
                header('location:' . SITEURL . 'update.php');
            } else
                header('location:' . SITEURL . 'add.php');
        }
    }
}
?>