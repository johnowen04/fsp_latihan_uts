<?php
require_once("class/student.php");
require_once("class/faculty.php");

if (isset($_POST['btnUpdateStudent'])) {
    $student = array('nrp' => $_POST['nrp'], 'name' => $_POST['name'], 'ipk' => $_POST['ipk'], 'birthdate' => $_POST['birthdate'], 'faculty_id' => $_POST['faculty_id']);

    $obj_student = new student();
    $affected = $obj_student->update_student($student);

    header("location: index.php?update_success=$affected");
} else {
    $obj_faculty = new faculty();
    $arr_faculty = $obj_faculty->get_array_faculty();

    if (isset($_POST['nrp_terpilih'])) {
        $nrp_terpilih = $_POST['nrp_terpilih'];
    }

    $obj_student = new student();
    $res_student = $obj_student->get_specific_student($nrp_terpilih);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <form method="post">
        <?php
        if ($res_student->num_rows > 0) {
            while ($row = $res_student->fetch_assoc()) {
                echo "<p>NRP: <input type='text' name='nrp' value=" . $row['nrp'] . " disabled></p>";
                echo "<p>NRP: <input type='text' name='name' value=" . $row['name'] . "></p>";
                echo "<p>NRP: <input type='number' step='0.001' name='ipk' value=" . $row['ipk'] . "></p>";
                echo "<p>Birthdate: <input type='date' name='birthdate' value=" . $row['birthdate'] . "></p>";
                echo "<p>Fakultas:
                <select name='faculty_id' id='selFaculty'>
                    <option value=''>-- Pilih Fakultas --</option>";
                foreach ($arr_faculty as $id => $nama) {
                    if ($id == $row['faculty_id']) {
                        echo "<option value='" . $id . "' selected>" . $nama . "</option>";
                    } else {
                        echo "<option value='" . $id . "'>" . $nama . "</option>";
                    }
                }
                echo "</select>";
                echo "</p>";
                
                echo "<input type='hidden' name='nrp' value='".$row['nrp']."'>";
                echo "<p><input type='submit' name='btnUpdateStudent' value='Submit'></p>";
            }
        }
        ?>
    </form>
</body>

</html>