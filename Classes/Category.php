<?php

Class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategories() {
        $stmt = $this->db->prepare("SELECT * FROM tblcategories WHERE active = 1");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoryById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tblcategories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createCategory($name) {
        $stmt = $this->db->prepare("INSERT INTO tblcategories (category_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        $stmt = $this->db->prepare("UPDATE tblcategories SET active = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}