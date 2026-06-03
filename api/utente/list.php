<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$pdo  = getConnection();
$stmt = $pdo->query("
    SELECT IdUtente, Nome, Cognome, Ruolo, Citta, Sesso, DataNascita, SaldoWallet, Client_IdClient
    FROM Utente
    ORDER BY Cognome, Nome
");
$utenti = $stmt->fetchAll();

jsonResponse(true, 'Lista utenti recuperata', ['utenti' => $utenti]);
