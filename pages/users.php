<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();


if (post("username")) {
    $username = post("username");
    $password = sha1(post("password"));
    $api_key = rand(100000, 999999);
    $cek = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
    if ($cek->num_rows > 0) {
        toastr_set("error", _USERNAME_NOT_AVAILABLE);
    } else {
        $q = mysqli_query($conn, "INSERT INTO account (username, password, api_key, chunk)
        VALUES ('$username','$password','$api_key','60')");
        toastr_set("success", _USER_ADD_SUCCESS);
        //redirect("login.php");
    }
}

if (get("act") == "hapus") {
    $id = get("id");
    $uname = getSingleValDB("account", "id", "$id", "username");
    if ($uname == "admin") { die("Can not delete Super Admin Account!"); };
    $q = mysqli_query($conn, "DELETE FROM account WHERE id='$id'");
    $q2= mysqli_query($conn, "DELETE FROM device WHERE pemilik='$uname'");
    toastr_set("success", _USER_DELETE_SUCCESS);
}

if (get("act") == "loginas") {
    $uname = get("username");
    $_SESSION['login'] = true;
    $_SESSION['username'] = $uname;
    $_SESSION['level'] = getSingleValDB("account", "username", $uname, "level");
    if ($_SESSION['level'] == 1) {
        redirect("home.php");
    } else {redirect("settings.php");}
}

require_once('../templates/header.php');
?>

<div class="container-fluid">

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                <?php echo _USER_ADD ?>
            </button>
            <br>
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo _USERS ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?php echo _ID ?></th>
                                    <th><?php echo _USERNAME ?></th>
                                    <th><?php echo _LEVEL ?></th>
                                    <th><?php echo _ACTION ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q = mysqli_query($conn, "SELECT * FROM account where id > 1 ORDER BY id DESC");
                                while ($row = mysqli_fetch_assoc($q)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['id'] . '</td>';
                                    echo '<td>' . $row['username'] . '</td>';
                                    if ($row['level'] == 1) {
                                        echo '<td>Admin</td>';
                                    } else {
                                        echo '<td>User</td>';
                                    }
                                    echo '<td>';
                                    echo '<a class="btn btn-danger" onclick="return confirm(\'' . _USER_DELETE_CONFIRM . '\');" href="users.php?act=hapus&id=' . $row['id'] . '">' . _DELETE . '</a>    ';
                                    echo '<a class="btn btn-primary" onclick="return confirm(\'' . _LOGIN_AS_CONFIRM . '\');" href="users.php?act=loginas&username=' . $row['username'] . '">' . _LOGIN_AS . '</a>';
                                    //echo '<td><a href="users.php?act=hapus&id=' . $row['id'] . '"><button class="btn btn-danger" onclick="return confirm(\'' . _USER_DELETE_CONFIRM . '\')">' . _DELETE . '</button></a></td>';
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php require_once('../templates/footer.php'); ?>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _LOGOUT_TITLE ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?php echo _LOGOUT_BODY ?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo _CANCEL ?></button>
                <a class="btn btn-primary" href="<?= $base_url; ?>auth/logout.php"><?php echo _LOGOUT ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Add Users Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _USER_ADD ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <label> <?php echo _USERNAME ?> </label>
                    <input type="text" name="username" required class="form-control">
                    <br>
                    <label> <?php echo _PASSWORD ?> </label>
                    <input type="password" name="password" required class="form-control">
                    <br>
                    <label for="exampleFormControlSelect1"><?php echo _LEVEL1 ?></label>
                    <select class="form-control" id="exampleFormControlSelect1" name="level">
                        <option value="1"><?php echo _ADMIN ?></option>
                        <option value="2"><?php echo _USER ?></option>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" class="btn btn-primary"><?php echo _SAVE ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.0/socket.io.js" integrity="sha512-+l9L4lMTFNy3dEglQpprf7jQBhQsQ3/WvOnjaN/+/L4i0jOstgScV0q2TjfvRF4V+ZePMDuZYIQtg5T4MKr+MQ==" crossorigin="anonymous"></script>
<script>
<?php

toastr_show();

?>
</script>
</body>

</html>