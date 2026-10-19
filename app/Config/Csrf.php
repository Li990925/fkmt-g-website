<?php
namespace app\Config;

/**
 * Proteksi Cross-Site Request Forgery (CSRF) berbasis token session.
 */
class Csrf {
    const FIELD = 'csrf_token';

    /**
     * Ambil (atau buat) token CSRF untuk session aktif
     */
    public static function token() {
        if (empty($_SESSION[self::FIELD])) {
            $_SESSION[self::FIELD] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::FIELD];
    }

    /**
     * Hidden input berisi token, untuk disisipkan ke dalam <form>
     */
    public static function field() {
        return '<input type="hidden" name="' . self::FIELD . '" value="' . htmlspecialchars(self::token(), ENT_QUOTES) . '">';
    }

    /**
     * Validasi token yang dikirim lewat POST
     */
    public static function verify() {
        $sent = $_POST[self::FIELD] ?? '';
        return is_string($sent)
            && !empty($_SESSION[self::FIELD])
            && hash_equals($_SESSION[self::FIELD], $sent);
    }

    /**
     * Sisipkan token secara otomatis ke setiap <form method="POST"> di dalam HTML
     */
    public static function injectIntoForms($html) {
        $field = self::field();
        return preg_replace_callback(
            '/<form\b[^>]*\bmethod\s*=\s*["\']?post["\']?[^>]*>/i',
            function ($m) use ($field) {
                return $m[0] . $field;
            },
            (string)$html
        );
    }
}
