<html>

<head>
    <title>Export Data Ke Excel Dengan PHP - www.malasngoding.com</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;

        }

        a {
            background: blue;
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>

    <?php
    require('../helper/connection.php');
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Nomor.xls");
    ?>



    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Nomor</th>
            <th>Pesan Default</th>

        </tr>
        <?php


        // menampilkan data pegawai
        $data = mysqli_query($conn, "select * from nomor");
        $no = 1;
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $d['nama']; ?></td>
                <td><?php echo $d['nomor']; ?></td>
                <td><?php echo utf8_decode($d['pesan']); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>