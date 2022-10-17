<?php
require_once("class/student.php");

if (isset($_POST['nrp_terpilih'])) {
    $nrp = $_POST['nrp_terpilih'];

    $obj_student = new student();
    $affected = $obj_student->delete_student($nrp);
}

header("location: index.php");
