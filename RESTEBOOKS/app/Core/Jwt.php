<?php

namespace App\Core;

/**
 * Minimal HS256 JWT encode/decode for the REST API guard.
 * For anything beyond this scaffold, swap in firebase/php-jwt (already
 * listed in composer.json) — this class exists so the API works even
 * before `composer install` has been run.
 */
class Jwt
{
    private static function secret(): string
    {
        $config = require BASE_PATH . '/config/app.php';
        return $config['jwt_secret'];
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
    }

    public static function encode(array $payload, int $ttlSeconds = 86400): string
    {
        $header = self::base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttlSeconds;
        $payloadEncoded = self::base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "{$header}.{$payloadEncoded}", self::secret(), true);
        $signatureEncoded = self::base64UrlEncode($signature);

        return "{$header}.{$payloadEncoded}.{$signatureEncoded}";
    }

    public static function decode(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }
        [$header, $payload, $signature] = $parts;

        $expected = self::base64UrlEncode(hash_hmac('sha256', "{$header}.{$payload}", self::secret(), true));
        if (!hash_equals($expected, $signature)) {
            return null;
        }

        $data = json_decode(self::base64UrlDecode($payload), true);
        if (!$data || ($data['exp'] ?? 0) < time()) {
            return null;
        }

        return $data;
    }
}
