<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$idClient = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idClient <= 0) {
    jsonResponse(false, 'ID client non valido', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("SELECT IdClient, NomeClient FROM Client WHERE IdClient = ? LIMIT 1");
$stmt->execute([$idClient]);
$client = $stmt->fetch();

if (!$client) {
    jsonResponse(false, 'Client non trovato', [], 404);
}

jsonResponse(true, 'Client trovato', ['client' => $client]);
