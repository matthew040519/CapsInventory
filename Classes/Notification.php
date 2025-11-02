<?php


    Class Notification {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllNotifications() {
            $stmt = $this->db->prepare("SELECT * FROM notifications INNER JOIN tblcustomer ON notifications.customer_id = tblcustomer.id ORDER BY tdate DESC");
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function addNotification($message, $user_id, $customer_id, $date, $module, $link) {
            $queryNotif = "INSERT INTO notifications (message, tdate, user_id, customer_id, module, link) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtNotif = $this->db->prepare($queryNotif);
            $stmtNotif->bind_param("ssiiss", $message, $date, $user_id, $customer_id, $module, $link);
            $stmtNotif->execute();
        }

        public function markAsRead($notification_id) {
            $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
            $stmt->bind_param("i", $notification_id);
            return $stmt->execute();
        }
    }