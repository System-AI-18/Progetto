<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$idClient = isset($_GET['idClient']) ? (int)$_GET['idClient'] : 0;

if ($idClient <= 0) {
    jsonResponse(false, 'ID client non valido', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    SELECT 
        c.Client_IdClient,
        c.Server_IdServer,
        c.DataOra,
        cl.NomeClient,
        s.NomeServer
    FROM comunica c
    INNER JOIN Client cl ON cl.IdClient = c.Client_IdClient
    INNER JOIN Server s  ON s.IdServer  = c.Server_IdServer
    WHERE c.Client_IdClient = ?
    ORDER BY c.DataOra DESC
");
$stmt->execute([$idClient]);
$log = $stmt->fetchAll();

jsonResponse(true, 'Log recuperato', ['log' => $log]);
