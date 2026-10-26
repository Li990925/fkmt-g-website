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
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Proteksi brute force: batasi 10 kali percobaan gagal berturut-turut (lockout 3 menit)
            $attempts = $_SESSION['login_attempts'] ?? 0;
            $lastAttempt = $_SESSION['last_login_attempt'] ?? 0;
            if ($attempts >= 10 && (time() - $lastAttempt) < 180) {
                $remaining = 180 - (time() - $lastAttempt);
                $error = "Terlalu banyak percobaan login gagal. Silakan tunggu {$remaining} detik sebelum mencoba kembali.";
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            } elseif ($attempts >= 10 && (time() - $lastAttempt) >= 180) {
                // Reset setelah masa jeda berakhir
                $_SESSION['login_attempts'] = 0;
            }

            if (!\app\Config\Csrf::verify()) {
                $error = "Sesi login kedaluwarsa. Silakan coba lagi.";
                require_once __DIR__ . '/../../views/auth/login.php';
                return;
            }
            
            require_once __DIR__ . '/../../app/Config/Database.php';
            $db = new \app\Config\Database();
            $conn = $db->getConnection();
            
            $stmt = $conn->prepare("SELECT * FROM admin WHERE LOWER(username) = LOWER(?) LIMIT 1");
            $stmt->execute([$username]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if ($admin && (password_verify($password, $admin['password']) || password_verify(trim($password), $admin['password']))) {
                session_regenerate_id(true);
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = (int)$admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['admin_nama'] = !empty($admin['nama']) ? $admin['nama'] : $admin['username'];
                $_SESSION['admin_role'] = $admin['role'] ?? 'admin';
                // Reset counter percobaan login gagal
                unset($_SESSION['login_attempts'], $_SESSION['last_login_attempt']);
                header('Location: /admin');
                exit;
            } else {
                $_SESSION['login_attempts'] = ($attempts + 1);
                $_SESSION['last_login_attempt'] = time();
                $sisa = 5 - $_SESSION['login_attempts'];
                if ($sisa > 0) {
                    $error = "Username atau password salah! (Sisa percobaan: {$sisa}x)";
                } else {
                    $error = "Terlalu banyak percobaan gagal. Akun dikunci sementara selama 5 menit.";
                }
            }
        }
        
        require_once __DIR__ . '/../../views/auth/login.php';
    }
    
    public function logout() {
        // Kosongkan seluruh data session
        $_SESSION = [];
        // Hapus cookie session dari browser
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header('Location: /');
        exit;
    }
}
