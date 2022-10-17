<?php
require_once("class/student.php");
require_once("class/faculty.php");

$obj_faculty = new faculty();
$arr_faculty = $obj_faculty->get_array_faculty();

if (isset($_POST['btnAddStudent'])) {
    if (!isset($_POST['nrp'])) {
        $error = 'NRP cannot be empty';
    } else if (!isset($_POST['name'])) {
        $error = 'Name cannot be empty';
    } else if (!isset($_POST['ipk'])) {
        $error = 'IPK cannot be empty';
    }else if (!isset($_POST['birthdate'])) {
        $error = 'Birthdate cannot be empty';
    }else if (!isset($_POST['faculty_id'])) {
        $error = 'Faculty cannot be empty';
    } else {
        $obj_student = new student();
        $student = array('nrp' => $_POST['nrp'], 'name' => $_POST['name'], 'ipk' => $_POST['ipk'], 'birthdate' => $_POST['birthdate'], 'faculty_id' => $_POST['faculty_id']);
        $success = $obj_student->add_student($student);

        header("location: index.php?add_success=$success");
    }

    echo $error;
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
        <p>NRP: <input type="text" name="nrp"></p>
        <p>Name: <input type="text" name="name"></p>
        <p>IPK: <input type="number" step="0.001" name="ipk"></p>
        <p>Birthdate: <input type="date" name="birthdate"></p>
        <p>Fakultas:
        <select name='faculty_id' id='selFaculty'>
            <option value=''>-- Pilih Fakultas --</option>

            <?php
            foreach ($arr_faculty as $id => $nama) {
                echo "<option value='" . $id . "'>" . $nama . "</option>";
            }
            echo "</select>";
            ?>
        </p>

        <p><input type='submit' name='btnAddStudent' value='Submit'></p>
    </form>
</body>
</html>