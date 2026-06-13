<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

define('JWT_SECRET', 'chiavemoltosegretaelunghissima');
define('JWT_EXPIRY', 3600);

function generateToken(int $idUtente, string $ruolo): string {
    $payload = [
        'iat'      => time(),
        'exp'      => time() + JWT_EXPIRY,
        'idUtente' => $idUtente,
        'ruolo'    => $ruolo
    ];
    return JWT::encode($payload, JWT_SECRET, 'HS256');
}

function requireAuth(): object {
    // XAMPP su Apache può non passare Authorization header — questo lo gestisce
    $authHeader = $_SERVER['HTTP_AUTHORIZATION']
        ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
        ?? getallheaders()['Authorization']
        ?? '';

    if (empty($authHeader) || !str_starts_with($authHeader, 'Bearer ')) {
        jsonResponse(false, 'Token mancante o non valido', [], 401);
    }

    $token = substr($authHeader, 7);

    try {
        return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
    } catch (Exception $e) {
        jsonResponse(false, 'Token scaduto o non valido', [], 401);
    }
}

function requireRole(object $tokenPayload, string $ruoloRichiesto): void {
    if ($tokenPayload->ruolo !== $ruoloRichiesto) {
        jsonResponse(false, 'Accesso non autorizzato per questo ruolo', [], 403);
    }
}

function requireMethod(string $method): void {
    if ($_SERVER['REQUEST_METHOD'] !== strtoupper($method)) {
        jsonResponse(false, 'Metodo non consentito', [], 405);
    }
}

function getBody(): array {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!is_array($body)) {
        jsonResponse(false, 'Body della richiesta non valido', [], 400);
    }
    return $body;
}
