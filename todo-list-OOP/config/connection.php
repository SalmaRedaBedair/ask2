<?php
define('SITEURL', 'http://localhost/helpers/todo-list-OOP/');

class Connection
{
    public $mysqli;

    public function __construct($host, $user_name, $password, $database)
    {
        $this->mysqli = new mysqli($host, $user_name, $password, $database);

        if ($this->mysqli->connect_errno) {
            die("Failed to connect to MySQL: " . $this->mysqli->connect_error);
        }
    }

    private function dateCorrection($date)
    {
        $date = strtotime($date);
        $date = new DateTime('@' . $date);
        $date = $date->format('Y-m-d');
        return $date;
    }

    public function getData($tablename, $order, $condition = 1)
    {
        $statement = "SELECT * FROM $tablename  where $condition ORDER BY $order";
        // echo $statement;
        // die();
        $res = $this->mysqli->query($statement);

        if ($res === false) {
            error_log("Error executing query: " . $this->mysqli->error);
            return false;
        }

        if ($res->num_rows === 0) {
            return [];
        }

        $notes = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_free_result($res);

        return $notes;
    }
    public function getById($tablename, $id)
    {
        return $this->getData($tablename, 'id', "id=$id")[0];
    }
    public function adduser($data)
    {
        $name = $data['name'] ?? '';
        $user_name = $data['user_name'] ?? '';
        $password = $data['password'] ?? '';

        $statement = $this->mysqli->prepare('INSERT INTO `user`(`name`, `user_name`, `password`) VALUES (?,?, ?)');
        if ($statement === false) {
            error_log("Error preparing statement: " . $this->mysqli->error);
            return false;
        }

        $statement->bind_param('sss', $name, $user_name, $password);

        $res = $statement->execute();
        if ($res === false) {
            error_log("Error executing statement: " . $statement->error);
            return false;
        }
        return true;
    }
    public function addTask($data)
    {

        $name = $data['name'] ?? '';
        $start_date = $data['start_date'] ?? '';
        $end_date = $data['end_date'] ?? '';
        $status = $data['status'] ?? '';
        $user_id = $data['user_id'] ?? 0;

        $start_date = $this->dateCorrection($data['start_date']);
        $end_date = $this->dateCorrection($data['end_date']);

        $statement = $this->mysqli->prepare('INSERT INTO `task`(`name`, `start_date`, `end_date`, `status`, `user_id`) VALUES (?,?,?,?,?)');
        if ($statement === false) {
            error_log("Error preparing statement: " . $this->mysqli->error);
            return false;
        }

        $statement->bind_param('ssssi', $name, $start_date, $end_date, $status, $user_id);
        $res = $statement->execute();
        if ($res === false) {
            error_log("Error executing statement: " . $statement->error);
            return false;
        }
        return true;
    }
    public function updateUser($data)
    {
        $id = $data['id'];
        $row = $this->getData('user', 'id', "id=$id")[0];
        $name = $data['name'] ?? $row['name'];
        $user_name = $data['user_name'] ?? $row['$user_name'];
        $password = $data['password'] ?? $row['password'];
        $deleted_tasks = $data['deleted_tasks'] ?? $row['deleted_tasks'];

        $statement = $this->mysqli->prepare("UPDATE `user` SET `name` = ?, `user_name` = ?,`password` =?,`deleted_tasks`=? WHERE `id` = ?");
        if ($statement === false) {
            error_log("Error preparing statement: " . $this->mysqli->error);
            return false;
        }

        $statement->bind_param('sssii', $name, $user_name, $password, $deleted_tasks, $id);

        $res = $statement->execute();
        if ($res === false) {
            error_log("Error executing statement: " . $statement->error);
            return false;
        }
        return true;
    }

    public function updateTask($data)
    {
        $id = $data['id'];
        $row = $this->getData('task', 'id', "id=$id")[0];
        $name = $data['name'] ?? $row['name'];
        $start_date = $data['start_date'] ?? $row['start_date'];
        $end_date = $data['end_date'] ?? $row['end_date'];
        $status = $data['status'] ?? $row['status'];
        $user_id = $data['user_id'] ?? $row['user_id'];

        $start_date = $this->dateCorrection($start_date);
        $end_date = $this->dateCorrection($end_date);

        $statement = $this->mysqli->prepare("UPDATE `task` SET `name` = ?, `start_date` = ?,`end_date` =?,`status`=?,`user_id`=? WHERE `id` = ?");
        if ($statement === false) {
            error_log("Error preparing statement: " . $this->mysqli->error);
            return false;
        }

        $statement->bind_param('ssssii', $name, $start_date, $end_date, $status, $user_id, $id);

        $res = $statement->execute();
        if ($res === false) {
            error_log("Error executing statement: " . $statement->error);
            return false;
        }
        return true;
    }
    public function remove($tablename, $id)
    {
        if ($tablename == 'task') {
            $data = $this->getById('task', $id);
            $user_id = $data['user_id'];
            $data2 = $this->getById('user', $user_id);
            $deleted_tasks = $data2['$deleted_tasks'];
            $deleted_tasks++;
            $statement = $this->mysqli->prepare("UPDATE `user` SET `deleted_tasks`=? WHERE `id` = ?");
            $statement->bind_param('ii', $deleted_tasks, $id);
            $statement->execute();
        }

        $statement = $this->mysqli->prepare("DELETE FROM $tablename WHERE id = ?");
        $statement->bind_param('i', $id);

        $res = $statement->execute();
        if ($res === false) {
            error_log("Error executing statement: " . $statement->error);
            return false;
        }
        return true;
    }
}
return new connection('localhost', 'root', '', 'todo-list');
?>