<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('POST');

$body      = getBody();
$titolo    = trim($body['Titolo'] ?? '');
$messaggio = trim($body['Messaggio'] ?? '');
$destId    = isset($body['Destinatario_IdUtente']) ? (int)$body['Destinatario_IdUtente'] : null;

if (empty($titolo) || empty($messaggio)) {
    jsonResponse(false, 'Titolo e Messaggio sono obbligatori', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    INSERT INTO Notifica (Titolo, Messaggio, DataOra, Destinatario_IdUtente)
    VALUES (?, ?, NOW(), ?)
");
$stmt->execute([$titolo, $messaggio, $destId]);

jsonResponse(true, 'Notifica inviata con successo', ['IdNotifica' => (int)$pdo->lastInsertId()], 201);
