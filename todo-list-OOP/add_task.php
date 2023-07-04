<?php
include_once('partials/menu.php');
require_once('submit.php');
$user_id=$_SESSION['id'];
?>

<body>
    <div class="menu text-center">
        <div class="wrapper">
            <a href="userpage.php" class="home-icon">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </div>
    <!-- menu section ends -->

    <div class="main-contet">
        <div class="wrapper">
            <h1>Add New Task</h1>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="name">Name:</label>
                        </td>
                        <td>
                            <input type="text" name="name" id="name"  >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="start_date">Start Date:</label>
                        </td>
                        <td>
                            <input type="date" name="start_date" id="start_date"  ><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="end_date">End Date:</label>
                        </td>
                        <td>
                            <input type="date" name="end_date" id="end_date"><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="status">Status:</label>
                        </td>
                        <td>
                            <select name="status" id="status">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name='user_id' value="<?=$user_id?>">
                            <input name="add_task" type="submit" class="btn btn-danger" value="Add Task">
                        </td>
                    </tr>
                </table>
            </form>

        </div>
    </div>

</body>

<?php
include_once('partials/footer.php');

if(isset($_POST['add_task'])){
    submit($_POST,'task','add');
}
?>