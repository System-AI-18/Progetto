<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$pdo  = getConnection();
$stmt = $pdo->query("
    SELECT IdClient, NomeClient
    FROM Client
    ORDER BY NomeClient
");
$clienti = $stmt->fetchAll();

jsonResponse(true, 'Lista client recuperata', ['clienti' => $clienti]);
