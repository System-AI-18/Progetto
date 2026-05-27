<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('POST');

$body       = getBody();
$nomeServer = trim($body['NomeServer'] ?? '');

if (empty($nomeServer)) {
    jsonResponse(false, 'NomeServer è obbligatorio', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("INSERT INTO Server (NomeServer) VALUES (?)");
$stmt->execute([$nomeServer]);

jsonResponse(true, 'Server creato con successo', ['IdServer' => (int)$pdo->lastInsertId()], 201);
