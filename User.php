<?php
class User {
    private $conn;
    private $table_name = "registration";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($full_name, $username, $email, $password) {
        $sql = "INSERT INTO " . $this->table_name . " (full_name, username, email, password)
                VALUES (:full_name, :username, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([
            ':full_name' => htmlspecialchars(strip_tags($full_name)),
            ':username' => htmlspecialchars(strip_tags($username)),
            ':email' => htmlspecialchars(strip_tags($email)),
            ':password' => $hashed_password
        ]);
    }

    public function login($username_or_email, $password) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE username = :ue OR email = :ue";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ue' => $username_or_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>