<?php 


   class Supplier {
       private $db;

       public function __construct($db) {
           $this->db = $db;
       }

       public function getAllSuppliers() {
           $stmt = $this->db->prepare("SELECT * FROM tblsupplier");
           $stmt->execute();
           return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
       }

       public function getSupplierById($id) {
           $stmt = $this->db->prepare("SELECT * FROM tblsupplier WHERE id = ?");
           $stmt->bind_param("i", $id);
           $stmt->execute();
           return $stmt->get_result()->fetch_assoc();
       }

       public function createSupplier($name, $address) {
           $stmt = $this->db->prepare("INSERT INTO tblsupplier (supplier_name, supplier_address) VALUES (?, ?)");
           $stmt->bind_param("ss", $name, $address);
           return $stmt->execute();
       }
   }