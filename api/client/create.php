<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('POST');

$body       = getBody();
$nomeClient = trim($body['NomeClient'] ?? '');

if (empty($nomeClient)) {
    jsonResponse(false, 'NomeClient è obbligatorio', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("INSERT INTO Client (NomeClient) VALUES (?)");
$stmt->execute([$nomeClient]);

jsonResponse(true, 'Client creato con successo', ['IdClient' => (int)$pdo->lastInsertId()], 201);
