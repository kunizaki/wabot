<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();
//cekAdmin();

if (post("pesan")) {
    $username = $_SESSION['username'];
    $pesan = post("pesan");
    $sender = post("device");
    // var_dump($sender); die;
    $jadwal = date("Y-m-d H:i:s", strtotime(post("tgl") . " " . post("jam")));
    if (!empty($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        // Be sure we're dealing with an upload
        if (is_uploaded_file($_FILES['media']['tmp_name']) === false) {
            throw new \Exception('Error on upload: Invalid file definition');
        }

        // Rename the uploaded file
        $uploadName = $_FILES['media']['name'];
        $ext = strtolower(substr($uploadName, strripos($uploadName, '.') + 1));

        $allow = ['pdf', 'jpg'];
        if (in_array($ext, $allow)) {
            if ($ext == "pdf") {
                $filename = round(microtime(true)) . mt_rand() . '.pdf';
            }

            if ($ext == "jpg") {
                $filename = round(microtime(true)) . mt_rand() . '.jpg';
            }
        } else {
            toastr_set("error", "Format  jpg, pdf only");
            redirect("scheduled.php");
            exit;
        }

        move_uploaded_file($_FILES['media']['tmp_name'], 'uploads/' . $filename);
        // Insert it into our tracking along with the original name
        $media = $base_url . "pages/uploads/" . $filename;
    } else {
        $media = null;
    }



    if (isset($_POST['target'])) {
        foreach ($_POST['target'] as $data) {
            $n = $data;
            $ceknomor = mysqli_query($conn, "SELECT * FROM nomor WHERE nomor = '$n' AND made_by = '$username'");
            $data2 = $ceknomor->fetch_assoc();
            $pesannya = strtr($pesan, array(
                '{nama}' => $data2['nama'],
            ));
            //$pesannya2 = utf8_encode($pesannya);
            if ($media == null) {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `jadwal`, `made_by`)
              VALUES('$sender','$n', '$pesannya', '$jadwal','$username')");
            } else {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `media`, `jadwal`, `made_by`)
              VALUES('$sender','$n', '$pesannya', '$media', '$jadwal', '$username')");
            }
        }
        // var_dump($n); die;

    } else {
        $username = $_SESSION['username'];
        $ceknomor = mysqli_query($conn, "SELECT * FROM nomor WHERE made_by = '$username'");
        while ($data = $ceknomor->fetch_assoc()) {
            $pesannya = strtr($pesan, array(
                '{nama}' => $data['nama'],
            ));
            //$pesannya2 = utf8_encode($pesannya);
            $n = $data['nomor'];
            if ($media == null) {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `jadwal`, `made_by`)
            VALUES('$sender','$n', '$pesannya', '$jadwal','$username')");
            } else {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `media`, `jadwal`, `made_by`)
            VALUES('$sender','$n', '$pesannya', '$media', '$jadwal', '$username')");
            }
            // var_dump($q);
        }
    }



    toastr_set("success", _SCHEDULED_MSG_SENT);
}

if (post("pesan2")) {
    $sender = post("device");
    $username = $_SESSION['username'];
    //$pesan = post("pesan");
    $jadwal = date("Y-m-d H:i:s", strtotime(post("tgl") . " " . post("jam")));
    if (!empty($_FILES['media']) && $_FILES['media']['error'] == UPLOAD_ERR_OK) {
        // Be sure we're dealing with an upload
        if (is_uploaded_file($_FILES['media']['tmp_name']) === false) {
            throw new \Exception('Error on upload: Invalid file definition');
        }

        // Rename the uploaded file
        $uploadName = $_FILES['media']['name'];
        $ext = strtolower(substr($uploadName, strripos($uploadName, '.') + 1));

        $allow = ['pdf', 'jpg'];
        if (in_array($ext, $allow)) {
            if ($ext == "png") {
                $filename = round(microtime(true)) . mt_rand() . '.png';
            }

            if ($ext == "pdf") {
                $filename = round(microtime(true)) . mt_rand() . '.pdf';
            }

            if ($ext == "jpg") {
                $filename = round(microtime(true)) . mt_rand() . '.jpg';
            }

            if ($ext == "jpeg") {
                $filename = round(microtime(true)) . mt_rand() . '.jpeg';
            }
        } else {
            toastr_set("error", "Format jpg, pdf only");
            redirect("scheduled.php");
            exit;
        }

        move_uploaded_file($_FILES['media']['tmp_name'], 'uploads/' . $filename);
        // Insert it into our tracking along with the original name
        $media = $base_url . "pages/uploads/" . $filename;
    } else {
        $media = null;
    }



    if (isset($_POST['target'])) {
        foreach ($_POST['target'] as $data) {
            $n = $data;
            $ceknomor = mysqli_query($conn, "SELECT * FROM nomor WHERE nomor = '$n' AND made_by = '$username'");
            $data2 = $ceknomor->fetch_assoc();
            $pesannya = strtr($data2['pesan'], array(
                '{nama}' => $data2['nama'],
            ));

            //$pesannya2 = utf8_encode($pesannya);
            if ($media == null) {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `jadwal`, `made_by`)
              VALUES('$sender','$n', '$pesannya', '$jadwal','$username')");
            } else {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `media`, `jadwal`, `made_by`)
              VALUES('$sender','$n', '$pesannya', '$media', '$jadwal', '$username')");
            }
        }
    } else {
        $username = $_SESSION['username'];
        $ceknomor = mysqli_query($conn, "SELECT * FROM nomor WHERE made_by = '$username'");
        while ($data = $ceknomor->fetch_assoc()) {
            $pesannya = strtr($data['pesan'], array(
                '{nama}' => $data['nama'],
            ));
            //$pesannya2 = utf8_encode($pesannya);
            $n = $data['nomor'];
            if ($media == null) {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `jadwal`, `made_by`)
            VALUES('$sender','$n', '$pesannya', '$jadwal','$username')");
            } else {
                $q = mysqli_query($conn, "INSERT INTO pesan(`sender`,`nomor`, `pesan`, `media`, `jadwal`, `made_by`)
            VALUES('$sender','$n', '$pesannya', '$media', '$jadwal', '$username')");
            }
            // var_dump($q);
        }
    }

    toastr_set("success", _SCHEDULED_MSG_SENT);
}

if (get("act") == "ku") {
    $id_blast = get("id");
    $q = mysqli_query($conn, "UPDATE `pesan` SET `status`='PENDING' WHERE `id`='$id_blast' AND `status`='FAILED'");
    toastr_set("success", _SCHEDULED_MSG_RESEND_SUCCESS);
    redirect("scheduled.php");
}

if (get("act") == "hd") {
    $q = mysqli_query($conn, "DELETE FROM pesan WHERE `status`='SENT'");
    toastr_set("success", _SCHEDULED_MSG_DELETE_SUCCESS);
    redirect("scheduled.php");
}

if (get("act") == "resend") {
    $q = mysqli_query($conn, "UPDATE `pesan` SET `status`='PENDING' WHERE `status`='FAILED'");
    toastr_set("success", _SCHEDULED_MSG_RESEND_SUCCESS);
    redirect("scheduled.php");
}

require_once('../templates/header.php');
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
        <?php echo _SCHEDULED_MSG_SEND ?>
    </button>
    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#kirimpesan2">
        <?php echo _SCHEDULED_MSG_SEND_FROM_SAVED ?>
    </button>
    <br>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="display:contents"><?php echo _MESSAGES ?></h6>
            <a class="btn btn-danger float-right" href="scheduled.php?act=hd"><?php echo _MESSAGES_SENT_DELETE ?></a>
            <a class="btn btn-success float-right" href="scheduled.php?act=resend"><?php echo _MESSAGES_FAILED_RESEND ?></a>
        </div>
        <style> table {
            border-spacing: 0px;
            table-layout: fixed;
            margin-left: auto;
            margin-right: auto;
        }
        </style>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo _SENDER ?></th>
                            <th><?php echo _PHONE ?></th>
                            <th><?php echo _MESSAGES ?></th>
                            <th><?php echo _MEDIA ?></th>
                            <th><?php echo _SCHEDULED ?></th>
                            <th><?php echo _STATUS ?></th>
                            <th><?php echo _ACTION ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $username = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM pesan WHERE made_by='$username' ORDER BY id DESC");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<tr>';
                            echo '<td>' . $row['sender'] . '</td>';
                            echo '<td>' . $row['nomor'] . '</td>';
                            //echo '<td>' . utf8_decode($row['pesan'])  . '</td>';
                            echo '<td>' . $row['pesan']  . '</td>';
                            echo '<td>' . $row['media'] . '</td>';
                            echo '<td>' . $row['jadwal'] . '</td>';
                            if ($row['status'] == "SENT") {
                                echo '<td><span class="badge badge-success status-container-' . $row['id'] . '">' . _SENT . '</span></td>';
                            } else if ($row['status'] == "FAILED") {
                                echo '<td><span class="badge badge-danger status-container-' . $row['id'] . '">' . _FAILED . '</span></td>';
                            } else {
                                echo '<td><span class="badge badge-warning status-container-' . $row['id'] . '">' . _PENDING . '</span></td>';
                            }

                            if ($row['status'] == "FAILED") {
                                echo '<td class="button-container-' . $row['id'] . '"><a style="margin:5px" class="btn btn-success" href="scheduled.php?act=ku&id=' . $row['id'] . '">' .  _RESEND. '</a><a style="margin:5px" class="btn btn-danger" href="deletemsg.php?id=' . $row['id'] . '">' . _DELETE . '</a></td>';
                            } else {
                                echo '<td class="button-container-' . $row['id'] . '"><a class="btn btn-danger" href="deletemsg.php?id=' . $row['id'] . '">' . _DELETE . '</a></td>';
                            }
                            echo '</tr>';
                        }

                        ?>
                    </tbody>
                </table>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _MESSAGE_SEND ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label><?php echo _SENDER ?></label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="device" style="width: 100%">
                        <?php

                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik='$u'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <label> <?php echo _MESSAGES ?> * </label>
                    <textarea name="pesan" required class="form-control"></textarea>
                    <br>
                    <label> <?php echo _MEDIA ?> </label>
                    <input type="file" name="media" class="form-control">
                    <br>
                    <label> <?php echo _SCHEDULE_DATE ?> * </label>
                    <input type="date" name="tgl" required class="form-control">
                    <br>
                    <label> <?php echo _SCHEDULE_TIME ?> * </label>
                    <input type="time" name="jam" required class="form-control">
                    <br>
                    <label><?php echo _MESSAGE_TARGET ?></label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="target[]" multiple="multiple" style="width: 100%">
                        <?php

                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM nomor WHERE made_by='$u'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <p>*<?php echo _LEAVE_EMPTY_SEND_ALL ?></p>
                    <br>
                    <br>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" name="pesan1" class="btn btn-primary"><?php echo _SAVE ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kirimpesan2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _MESSAGE_SEND ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label><?php echo _SENDER ?></label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="device" style="width: 100%">
                        <?php

                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM device WHERE pemilik='$u'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <input type="hidden" name="pesan2" value="yo">
                    <label> <?php echo _MEDIA ?> </label>
                    <input type="file" name="media" class="form-control">
                    <br>
                    <label> <?php echo _SCHEDULE_DATE ?> * </label>
                    <input type="date" name="tgl" required class="form-control">
                    <br>
                    <label> <?php echo _SCHEDULE_TIME ?> * </label>
                    <input type="time" name="jam" required class="form-control">
                    <br>
                    <label><?php echo _MESSAGE_TARGET ?></label>
                    <br>
                    <select class="form-control js-example-basic-multiple" name="target[]" multiple="multiple" style="width: 100%">
                        <?php

                        $u = $_SESSION['username'];
                        $q = mysqli_query($conn, "SELECT * FROM nomor WHERE made_by='$u'");

                        while ($row = mysqli_fetch_assoc($q)) {
                            echo '<option value="' . $row['nomor'] . '">' . $row['nama'] . ' (' . $row['nomor'] . ')</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <p>*<?php echo _LEAVE_EMPTY_SEND_ALL ?></p>
                    <br>
                    <br>
                    <div class="form-check">
                        <input type="checkbox" name="tiap_bulan" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Send Monthly</label>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _CLOSE ?></button>
                <button type="submit" name="kirimpesan2" class="btn btn-info"><?php echo _SAVE ?></button>
                </form>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2({
            dropdownAutoWidth: true
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>
    setInterval(sync, 4000);

    function sync() {
        let sync = localStorage.getItem('sync');
        if (sync == null) {
            sync = moment().format("YYYY-MM-DD HH:mm:ss");
            localStorage.setItem('sync', sync);
        }

        $.get("longpooling.php?lastsync=" + sync, function(data) {
            r = JSON.parse(data);

            jQuery.each(r, function(i, val) {
                let id = val.id;
                let id_blast = val.id_blast;
                if (val.status == "FAILED") {
                    $(".status-container-" + id).empty();
                    $(".status-container-" + id).html('Send Failed');
                    $(".status-container-" + id).addClass('badge-danger').removeClass('badge-warning');

                    $(".button-container-" + id).html('<a style="margin:5px" class="btn btn-success" href="scheduled.php?act=ku&id=' + id_blast + '"><?php echo _RESEND ?></a><a style="margin:5px" class="btn btn-danger" href="deletemsg.php?id=' + id + '"><?php echo _DELETE ?></a>');
                }

                if (val.status == "SENT") {
                    $(".status-container-" + id).empty();
                    $(".status-container-" + id).html('Sent');
                    $(".status-container-" + id).addClass('badge-success').removeClass('badge-warning');

                    $(".button-container-" + id).html('<a style="margin:5px" class="btn btn-danger" href="deletemsg.php?id=' + id + '"><?php echo _DELETE ?></a>');
                }
                console.log(id);
            });

            localStorage.setItem('sync', moment().format("YYYY-MM-DD HH:mm:ss"));

        });
    }
</script>
</body>

</html>