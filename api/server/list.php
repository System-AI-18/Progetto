<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$pdo  = getConnection();
$stmt = $pdo->query("
    SELECT IdServer, NomeServer
    FROM Server
    ORDER BY NomeServer
");
$servers = $stmt->fetchAll();

jsonResponse(true, 'Lista server recuperata', ['servers' => $servers]);
