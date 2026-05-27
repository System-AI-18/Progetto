<?php
error_reporting(0);
ini_set('display_errors', 0);
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

requireMethod('POST');

$body    = getBody();
$nome    = trim($body['Nome'] ?? '');
$cognome = trim($body['Cognome'] ?? '');

if (empty($nome) || empty($cognome)) {
    jsonResponse(false, 'Nome e Cognome sono obbligatori', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    SELECT IdUtente, Nome, Cognome, Ruolo, Citta, Sesso, DataNascita, SaldoWallet, Client_IdClient
    FROM Utente
    WHERE Nome = ? AND Cognome = ?
    LIMIT 1
");
$stmt->execute([$nome, $cognome]);
$utente = $stmt->fetch();

if (!$utente) {
    jsonResponse(false, 'Credenziali non valide', [], 401);
}

// Log connessione in comunica
if ($utente['Client_IdClient']) {
    $stmtLog = $pdo->prepare("
        INSERT INTO comunica (Client_IdClient, Server_IdServer, DataOra)
        VALUES (?, 1, NOW())
    ");
    $stmtLog->execute([$utente['Client_IdClient']]);
}

$token = generateToken($utente['IdUtente'], $utente['Ruolo']);

jsonResponse(true, 'Login effettuato con successo', [
    'token'  => $token,
    'utente' => [
        'IdUtente'        => $utente['IdUtente'],
        'Nome'            => $utente['Nome'],
        'Cognome'         => $utente['Cognome'],
        'Ruolo'           => $utente['Ruolo'],
        'Citta'           => $utente['Citta'],
        'Sesso'           => $utente['Sesso'],
        'DataNascita'     => $utente['DataNascita'],
        'SaldoWallet'     => $utente['SaldoWallet'],
        'Client_IdClient' => $utente['Client_IdClient']
    ]
]);
