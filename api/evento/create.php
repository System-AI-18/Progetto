<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('POST');

$body        = getBody();
$titolo      = trim($body['Titolo'] ?? '');
$descrizione = trim($body['Descrizione'] ?? '');
$scadenza    = trim($body['Scadenza'] ?? '');
$destId      = isset($body['Destinatario_IdUtente']) ? (int)$body['Destinatario_IdUtente'] : null;

if (empty($titolo)) {
    jsonResponse(false, 'Titolo è obbligatorio', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    INSERT INTO Evento (Titolo, Descrizione, DataOra, Scadenza, Destinatario_IdUtente)
    VALUES (?, ?, NOW(), ?, ?)
");
$stmt->execute([
    $titolo,
    $descrizione ?: null,
    $scadenza ?: null,
    $destId
]);

jsonResponse(true, 'Evento creato con successo', ['IdEvento' => (int)$pdo->lastInsertId()], 201);
