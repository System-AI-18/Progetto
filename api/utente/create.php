<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('POST');

$body           = getBody();
$nome           = trim($body['Nome'] ?? '');
$cognome        = trim($body['Cognome'] ?? '');
$ruolo          = trim($body['Ruolo'] ?? 'utente');
$citta          = trim($body['Citta'] ?? '');
$sesso          = trim($body['Sesso'] ?? '');
$dataNascita    = trim($body['DataNascita'] ?? '');
$clientIdClient = isset($body['Client_IdClient']) ? (int)$body['Client_IdClient'] : null;

if (empty($nome) || empty($cognome)) {
    jsonResponse(false, 'Nome e Cognome sono obbligatori', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    INSERT INTO Utente (Nome, Cognome, Ruolo, Città, Sesso, DataNascita, SaldoWallet, Client_IdClient)
    VALUES (?, ?, ?, ?, ?, ?, 0.00, ?)
");
$stmt->execute([
    $nome,
    $cognome,
    $ruolo,
    $citta ?: null,
    $sesso ?: null,
    $dataNascita ?: null,
    $clientIdClient
]);

jsonResponse(true, 'Utente creato con successo', ['IdUtente' => (int)$pdo->lastInsertId()], 201);
