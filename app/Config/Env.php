<?php
namespace app\Config;

class Env {
    private static $loaded = false;

    /**
     * Membaca dan memuat file .env ke environment PHP
     */
    public static function load($path = null) {
        if (self::$loaded) {
            return true;
        }

        if ($path === null) {
            $path = dirname(__DIR__, 2) . '/.env';
        }

        if (!file_exists($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            // Abaikan baris kosong dan komentar
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }

            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Hapus tanda kutip jika nilai diapit tanda kutip tunggal atau ganda
                if (preg_match('/^(["\'])(.*)\1$/', $value, $matches)) {
                    $value = $matches[2];
                }

                if (!array_key_exists($key, $_SERVER) && !array_key_exists($key, $_ENV)) {
                    putenv(sprintf('%s=%s', $key, $value));
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }

        self::$loaded = true;
        return true;
    }

    /**
     * Mengambil nilai konfigurasi dari environment
     */
    public static function get($key, $default = null) {
        self::load();
        
        $value = getenv($key);
        if ($value === false) {
            $value = $_ENV[$key] ?? $_SERVER[$key] ?? $default;
        }

        // Konversi tipe data boolean/null jika diperlukan
        if (is_string($value)) {
            $lower = strtolower($value);
            if ($lower === 'true') return true;
            if ($lower === 'false') return false;
            if ($lower === 'null') return null;
            if ($lower === 'empty') return '';
        }

        return $value;
    }
}
