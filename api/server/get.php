<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$idServer = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idServer <= 0) {
    jsonResponse(false, 'ID server non valido', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("SELECT IdServer, NomeServer FROM Server WHERE IdServer = ? LIMIT 1");
$stmt->execute([$idServer]);
$server = $stmt->fetch();

if (!$server) {
    jsonResponse(false, 'Server non trovato', [], 404);
}

jsonResponse(true, 'Server trovato', ['server' => $server]);
