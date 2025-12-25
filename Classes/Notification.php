<?php


    Class Notification {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getAllNotifications() {
            $stmt = $this->db->prepare("SELECT *, notifications.id as notification_id FROM notifications ORDER BY tdate DESC");
            
            $stmt->execute();
            $result = $stmt->get_result();
            $notifications = [];
            while ($row = $result->fetch_assoc()) {
                $notifications[] = $row;
            }
            $stmt->close();
            return $notifications;
        }

        public function addNotification($message, $user_id, $customer_id, $date, $module, $link) {
            date_default_timezone_set('Asia/Manila');
            $time = date('H:i:s');
            $queryNotif = "INSERT INTO notifications (message, time, tdate, user_id, customer_id, module, link) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtNotif = $this->db->prepare($queryNotif);
            $stmtNotif->bind_param("sssiiss", $message, $time, $date, $user_id, $customer_id, $module, $link);
            $stmtNotif->execute();
        }

        public function markAsRead($notification_id) {
            $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ?");
            $stmt->bind_param("i", $notification_id);
            return $stmt->execute();
        }
    }