<?php
class User {

    public function authenticate($username, $password) {
        $username = strtolower($username);  
        $db = db_connect();  

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :name");
        $stmt->bindValue(':name', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['auth'] = 1;
            $_SESSION['username'] = ucwords($username);  
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['is_admin'] = $user['is_admin']; 

            header('Location: /home');  
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header('Location: /login');
            exit;
        }
    }

    public function create_user($username, $password) {
        $db = db_connect();  

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        return $stmt->execute([$username, $hashed_password]);
    }
}
