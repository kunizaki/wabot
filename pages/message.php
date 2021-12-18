<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();
//cekAdmin();();

if (post("pesan")) {
    $nomor = post("nomor");
    $pesan = post("pesan");
    $sender = post("sender");

    //toastr_set("error", "fitur dimatikan sementara"); 
    $res = sendMSG($nomor, $pesan, $sender);
    //  var_dump($res); die;
    // var_dump($res); die;
    if ($res['status'] == "true") {
        toastr_set("success", _MESSAGE_SENT_SUCCESS);
    } else {
        toastr_set("error", $res['response']);
    }
}

if (post("nomormedia")) {
    $nomor = post("nomormedia");
    $pesan = post("pesan");
    $sender = post("sender");
    $filetype = post("filetype");
    $url = post("linkmedia");
    $a = explode('/', $url);
    $filename = $a[count($a) - 1];
    $a2 = explode('.', $filename);
    $namefile = $a2[count($a2) - 2];

    $res = sendMedia($nomor, $pesan, $sender, $filetype, $namefile, $url);
    if ($res['status'] == "true") {
        toastr_set("success", _MESSAGE_SENT_SUCCESS);
    } else {
        toastr_set("error", $res['message']);
    }
}
require('../templates/header.php')
?>


<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <!-- DataTales Example -->
        <div class="card shadow col-md-5 mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo _MESSAGE_SEND ?></h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <label for=""><?php echo _SENDER ?></label>
                    <select class="form-control" name="sender" style="width: 100%">
                        <?php
                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik='$u'");
                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nomor'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <label> <?php echo _PHONE ?> </label>
                    <input class="form-control" type="text" name="nomor" placeholder="<?php echo _PHONE_INCLUDE_COUNTRY ?>" required>
                    <br>
                    <label> <?php echo _MESSAGES ?> </label>
                    <input class="form-control" type="text" name="pesan" required>
                    <br>
                    <button class="btn btn-success" type="submit"><?php echo _SEND ?></button>
                </form>
            </div>
        </div>
        <div class="card shadow  col-md-5 ml-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo _SEND_MEDIA ?></h6>
                <label><?php echo _MEDIA_TYPE_SUPPORTED ?>: jpg, png, and pdf</label>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <label for=""><?php echo _SENDER ?></label>
                    <select class="form-control" name="sender" style="width: 100%">
                        <?php
                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik='$u'");
                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nomor'] . '</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <label> <?php echo _PHONE ?></label>
                    <input class="form-control" type="text" name="nomormedia" placeholder="<?php echo _PHONE_INCLUDE_COUNTRY ?>" required>
                    <br>
                    <label> <?php echo _MESSAGES ?> </label>
                    <input class="form-control" type="text" name="pesan">
                    <label> <?php echo _MESSAGE_INCLUDE_MEDIA ?></label>
                    <br>
                    <label> <?php echo _MEDIA_LINK ?> </label>
                    <input class="form-control" type="text" name="linkmedia" required>
                    <br>
                    <label> <?php echo _FILE_TYPE ?> </label>
                    <input class="form-control" type="text" name="filetype" required>
                    <label>jpg/png/jpeg/pdf</label>
                    <br>
                    <button class="btn btn-success" type="submit"><?php echo _SEND ?></button>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

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

<!-- Bootstrap core JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= $base_url; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= $base_url; ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= $base_url; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script>
    <?php

    toastr_show();

    ?>
</script>
</body>

</html>