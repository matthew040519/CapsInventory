<?php

Class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM tblproducts");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProductsWithCategories() {
        $stmt = $this->db->prepare("SELECT p.*, c.category_name FROM tblproducts p LEFT JOIN tblcategories c ON p.category_id = c.id");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countProducts() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS product_count FROM tblproducts");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['product_count'];
    }

    public function getLowStockCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) AS low_stock_count FROM tblproducts WHERE (SELECT IFNULL(SUM(quantity_in - quantity_out), 0) FROM tblproduct_transactions WHERE product_id = tblproducts.id) <= reorder_point");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['low_stock_count'];
    }

    public function getProductsWithQty() {
        $stmt = $this->db->prepare("SELECT p.*, c.category_name, IFNULL(SUM(q.quantity_in - q.quantity_out), 0) AS total_quantity 
                                    FROM tblproducts p 
                                    LEFT JOIN tblcategories c ON p.category_id = c.id 
                                    LEFT JOIN tblproduct_transactions q ON p.id = q.product_id 
                                    GROUP BY p.id");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tblproducts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createProduct($image, $product_name, $description, $price, $category_id, $re_order_point) {
        $stmt = $this->db->prepare("INSERT INTO tblproducts (image, product_name, description, price, category_id, reorder_point) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdii", $image, $product_name, $description, $price, $category_id, $re_order_point);
        return $stmt->execute();
    }

    public function updateProduct($id, $product_name, $description, $price, $category_id, $re_order_point, $image = null) {
        if ($image) {
            $stmt = $this->db->prepare("UPDATE tblproducts SET product_name = ?, description = ?, price = ?, category_id = ?, reorder_point = ?, image = ? WHERE id = ?");
            $stmt->bind_param("ssdiiss", $product_name, $description, $price, $category_id, $re_order_point, $image, $id);
        } else {
            $stmt = $this->db->prepare("UPDATE tblproducts SET product_name = ?, description = ?, price = ?, category_id = ?, reorder_point = ? WHERE id = ?");
            $stmt->bind_param("ssdiii", $product_name, $description, $price, $category_id, $re_order_point, $id);
        }
        return $stmt->execute();
    }
}