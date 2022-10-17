<?php
require_once("class/student.php");
require_once("class/faculty.php");

$obj_faculty = new faculty();
$arr_faculty = $obj_faculty->get_array_faculty();

if (isset($_GET['update_success'])) {
    if ($_GET['update_success'] == 1) {
        echo "Update Data Success";
    } else {
        echo "Update Data Failed";
    }
}

if (isset($_GET['add_success'])) {
    if ($_GET['add_success'] == 1) {
        echo "Add Data Success";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style type="text/css">
        table,
        th,
        tr,
        td {
            border: 1px solid black;
        }
    </style>
    <h1>Students</h1>
</head>

<body>
    <form>
        <p>Masukkan nama:
            <input type="text" name="cari_nama">
        </p>

        <p> Masukkan nrp:
            <input type="text" name="cari_nrp">
        </p>

        <p>Fakultas:
        <select name='cari_fakultas' id='selFaculty'>
            <option value=''>-- Pilih Fakultas --</option>

    <?php
    foreach ($arr_faculty as $id => $nama) {
        echo "<option value='" . $id . "'>" . $nama . "</option>";
    }
    echo "</select>";
    echo "</p>";

    echo "<input type='submit' value='Search'>";
    echo "</form>";
    echo "<br>";

    echo "<a href='add_student.php'>Add Student</a>";
    echo "<br>";
    echo "<br>";
    ?>

    <?php
    $placeholder = "Hasil pencarian untuk";
    $cari = null;

    if (isset($_GET['cari_nama'])) {
        if (!empty($_GET['cari_nama'])) {
            $cari['name'] = $_GET['cari_nama'];
            $placeholder .= " nama " . $cari['name'];
        }
    }

    if (isset($_GET['cari_nrp'])) {
        if (!empty($_GET['cari_nrp'])) {
            $cari['nrp'] = $_GET['cari_nrp'];
            $placeholder .= " nrp " . $cari['nrp'];
        }
    }

    if (isset($_GET['cari_fakultas'])) {
        if (!empty($_GET['cari_fakultas'])) {
            $cari['faculty_id'] = $_GET['cari_fakultas'];
            if ($cari['faculty_id'] <= sizeof($arr_faculty)) {
                $placeholder .= " fakultas " . $arr_faculty[$cari['faculty_id']];
            } else {
                $placeholder = "Fakultas tidak ditemukan";
            }
        }
    }

    if (!is_null($cari)) {
        echo "<p><i>$placeholder</i></p>";
    }

    $limit = 10;
    if (isset($_GET['offset'])) {
        $offset = $_GET['offset'];
    } else {
        $offset = 0;
    }

    $obj_student = new student();
    $res_student = $obj_student->get_student($cari, $offset, $limit);

    echo "<table>
            <tr>
                <th>NRP</th>
                <th>Name</th>
                <th>IPK</th>
                <th>Birthdate</th>
                <th>Faculty</th>
                <th>Action</th>
            </tr>";

    while ($row = $res_student->fetch_assoc()) {
        echo "<tr>";

        echo "<td>" . $row['nrp'] . "</td>";

        echo "<td>" . $row['name'] . "</td>";

        echo "<td>" . $row['ipk'] . "</td>";

        echo "<td>" . $row['birthdate'] . "</td>";

        echo "<td>" . $arr_faculty[$row['faculty_id']] . "</td>";

        echo "<td>";
        echo "<form action='update_student.php' method='post'>";
        echo "<input type='hidden' name='nrp_terpilih' value=" . $row['nrp'] . ">";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
        echo "<br>";
        echo "<form action='delete_student.php' method='post'>";
        echo "<input type='hidden' name='nrp_terpilih' value=" . $row['nrp'] . ">";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
    }
    echo "<table>";

    $total_data = $obj_student->get_jumlah_data($cari);
    include 'nomor_halaman.php';
    echo "<br>";
    echo generateNomorHalaman($total_data, $offset, $limit, $cari);
    ?>
</body>

</html>