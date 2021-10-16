<?php declare(strict_types=1);

namespace App\Utilities;

class Utilities
{
    public static function urlSafeBase64Encode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function urlSafeBase64Decode(string $data): string
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public static function encodeOutput(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function generateCryptographicNonce(int $length = 32): string
    {
        $length = $length < 8 ? 32 : $length;

        return self::urlSafeBase64Encode(random_bytes($length));
    }
}