<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('GET');

$idUtente = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idUtente <= 0) {
    jsonResponse(false, 'ID utente non valido', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    SELECT IdUtente, Nome, Cognome, Ruolo, Citta, Sesso, DataNascita, SaldoWallet, Client_IdClient
    FROM Utente
    WHERE IdUtente = ?
    LIMIT 1
");
$stmt->execute([$idUtente]);
$utente = $stmt->fetch();

if (!$utente) {
    jsonResponse(false, 'Utente non trovato', [], 404);
}

jsonResponse(true, 'Utente trovato', ['utente' => $utente]);
