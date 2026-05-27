<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('GET');

$idUtente = (int)$tokenPayload->idUtente;

$pdo  = getConnection();
$stmt = $pdo->prepare("SELECT SaldoWallet FROM Utente WHERE IdUtente = ?");
$stmt->execute([$idUtente]);
$utente = $stmt->fetch();

if (!$utente) {
    jsonResponse(false, 'Utente non trovato', [], 404);
}

jsonResponse(true, 'Saldo recuperato', ['SaldoWallet' => $utente['SaldoWallet']]);
