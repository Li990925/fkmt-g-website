<?php
namespace app\Controllers;

class AuthController {
    public function login() {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            header('Location: /admin');
            exit;
        }
        
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            require_once __DIR__ . '/../../app/Config/Database.php';
            $db = new \app\Config\Database();
            $conn = $db->getConnection();
            
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($admin && password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header('Location: /admin');
                exit;
            } else {
                $error = "Username atau password salah!";
            }
        }
        
        require_once __DIR__ . '/../../views/auth/login.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}
