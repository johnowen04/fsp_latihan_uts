<?php

require_once("db.php");

class student
{

    public function get_specific_student($nrp) {
        $sql = "SELECT * FROM students WHERE nrp=?";
        $stmt = db::get_connection()->prepare($sql);
        $stmt->bind_param("s", $nrp);

        $stmt->execute();
        $res = $stmt->get_result();

        return $res;
    }

    public function get_student($cari = null, $offset = null, $limit = null)
    {
        if (!is_null($cari)) {
            extract($cari);
        }

        $sql = "SELECT * FROM students WHERE nrp LIKE ? and name LIKE ? and faculty_id LIKE ?";

        if (empty($nrp)) {
            $nrp = "";
        }

        if (empty($name)) {
            $name = "";
        }

        if (empty($faculty_id)) {
            $faculty_id = "";
        }

        $nrp = "%$nrp%";
        $name = "%$name%";
        $faculty_id = "%$faculty_id%";

        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }

        $stmt = db::get_connection()->prepare($sql);

        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param("sssii", $nrp, $name, $faculty_id, $offset, $limit);
        } else {
            $stmt->bind_param("sss", $nrp, $name, $faculty_id);
        }

        $stmt->execute();
        $res = $stmt->get_result();

        return $res;
    }

    public function add_student($student)
    {
        $arr_col = array();
        $arr_tanya = array();

        foreach ($student as $column => $value) {
            $arr_col[] = $column;
            $arr_tanya[] = "?";
        }
        $sql = "INSERT INTO students(" . implode(",", $arr_col) . ") VALUES(" . implode(",", $arr_tanya) . ")";
        $stmt = db::get_connection()->prepare($sql);
        $stmt->bind_param(
            'ssdsi',
            $student["nrp"],
            $student["name"],
            $student["ipk"],
            $student["birthdate"],
            $student["faculty_id"]
        );

        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update_student($student)
    {
        $sql = "UPDATE students SET name=?, ipk=?, birthdate=?, faculty_id=? WHERE nrp=?";

        $stmt = db::get_connection()->prepare($sql);
        $stmt->bind_param(
            "sdsis",
            $student['name'],
            $student['ipk'],
            $student['birthdate'],
            $student['faculty_id'],
            $student['nrp']
        );

        $stmt->execute();
        return $stmt->affected_rows;
    }


    public function delete_student($nrp)
    {
        $sql = "DELETE FROM students WHERE nrp=?";

        $stmt = db::get_connection()->prepare($sql);
        $stmt->bind_param("s", $nrp);

        $stmt->execute();
        $affected = $stmt->affected_rows;

        return $affected;
    }

    public function get_jumlah_data($cari)
    {
        $res = $this->get_student($cari);
        return $res->num_rows;
    }
}
