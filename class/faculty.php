<?php

require_once("db.php");

class faculty {

    public function get_faculty() {
        $sql = "SELECT * FROM faculty";
        $stmt = db::get_connection()->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();

        return $res;
    }

    public function get_array_faculty() {
        $res = $this->get_faculty();

        $arr_faculty = [];
        while ($row = $res->fetch_assoc()) {
            $arr_faculty[$row['id']] = $row['name'];
        }

        return $arr_faculty;
    }
}