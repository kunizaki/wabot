<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");

$now = date("Y-m-d H:i:s");
$chunk = 100;
$q = mysqli_query($conn, "SELECT * FROM pesan WHERE UNIX_TIMESTAMP(jadwal) < UNIX_TIMESTAMP('$now') AND status='PENDING' ORDER BY id ASC LIMIT 100 ");
//var_dump($q->fetch_assoc()); die;
$i = 0;
while ($data = $q->fetch_assoc()) {
    $sender = $data['sender'];
    $nomor = $data['nomor'];
    $pesan = $data['pesan'];
    if ($data['media'] == null) {
        $send = sendMSG($nomor, $pesan, $sender);
        if ($send['status'] == "true") {
            $i++;
            $this_id = $data['id'];
            $q3 = mysqli_query($conn, "UPDATE pesan SET status = 'SENT' WHERE id='$this_id'");
        } else {
            $s = false;
        }
        usleep(100000);
    }
}
echo 'succes sent to ' . $i . ' numbers';
