<?php
include_once('partials/menu.php');
require_once('submit.php');
$user_id = $_SESSION['id'];
$data = $conn->getById('user', $user_id);
$rows = $conn->getData('task', 'start_date', "user_id=$user_id");
// print_r($rows);
// die();
?>

<body>
    <!-- menu section starts -->
    <div class="menu text-center">
        <div class="wrapper">
            <a href="index.php" class="home-icon">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </div>
    <!-- menu section ends -->

    <!-- show data by the start time of each -->

    <div class="main-content">
        <div class="wrapper">
            <h1>Welcome
                <?= ucwords($data['name']) ?> ❤️
            </h1>
            <br>
            <br>
            <a href="add_task.php" class="btn btn-primary">Add Task</a>
            <br>
            <br>
            <h2><u>My tasks:</u></h2>
            <br>
            <?php
            // completed grey line through checked
            // started black unchecked
            // time_out and not done red unchecked
            // will come grey unchecked
            
            // done | started | in progress | time_out
            foreach ($rows as $row) {
                ?>
                <div class="task">
                    <table>
                        <tr>
                            <td>
                                <form id="my-form-<?= $row['id'] ?>" action="" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['id'] ?>">
                                    <input type="hidden" name="status-<?= $row['id'] ?>" value="<?= $row['status'] ?>">
                                    <input class="checkbox" type="checkbox" id="checkbox-<?= $row['id'] ?>" <?php
                                      if ($row['status'] == 'done')
                                          echo 'checked' ?>>
                                    </form>
                                </td>
                                <td>
                                    <label for="checkbox-<?= $row['id'] ?>" class="<?php
                                      if ($row['status'] == 'done')
                                          echo 'deleted-text';
                                      else if ($row['status'] == 'not started')
                                          echo 'not-started';
                                      else if ($row['status'] == 'time out')
                                          echo 'time-out';
                                      ?>"> <?= $row['name'] ?></label>
                            </td>
                            <td>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
                                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-primary">Update</a>
                            </td>


                            <script>
                                var checkbox = document.getElementById('checkbox-<?= $row['id'] ?>');
                                var form = document.getElementById('my-form-<?= $row['id'] ?>');
                                var hiddenInput = form.querySelector('input[name="status-<?= $row['id'] ?>"]');

                                checkbox.addEventListener('click', function () {
                                    hiddenInput.value = checkbox.checked ? 'pending' : 'done';
                                    form.submit();
                                });

                                // Set the checked property of the checkbox based on the initial value of the hidden input
                                checkbox.checked = hiddenInput.value === 'done';
                            </script>
                            <?php
                            if (isset($_POST['id'])) {
                                $datas = $_POST;
                                $status_id = $row['id'];
                                $datas['status'] = $_POST["status-$status_id"];
                                $conn->updateTask($datas);
                                header('location:' . SITEURL . 'userpage.php');
                            }
                            ?>
                        </tr>
                    </table>
                    <br>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

    <?php
    include_once('partials/footer.php');





    ?>