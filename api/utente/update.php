<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('PUT');

$body     = getBody();
$idUtente = isset($body['IdUtente']) ? (int)$body['IdUtente'] : 0;

if ($idUtente <= 0) {
    jsonResponse(false, 'ID utente non valido', [], 400);
}

$campi  = [];
$valori = [];

if (isset($body['Nome']))             { $campi[] = 'Nome = ?';             $valori[] = trim($body['Nome']); }
if (isset($body['Cognome']))          { $campi[] = 'Cognome = ?';          $valori[] = trim($body['Cognome']); }
if (isset($body['Ruolo']))            { $campi[] = 'Ruolo = ?';            $valori[] = trim($body['Ruolo']); }
if (isset($body['Città']))            { $campi[] = 'Citta = ?';            $valori[] = trim($body['Città']); }
if (isset($body['Sesso']))            { $campi[] = 'Sesso = ?';            $valori[] = trim($body['Sesso']); }
if (isset($body['DataNascita']))      { $campi[] = 'DataNascita = ?';      $valori[] = trim($body['DataNascita']); }
if (isset($body['Client_IdClient'])) { $campi[] = 'Client_IdClient = ?';  $valori[] = (int)$body['Client_IdClient']; }

if (empty($campi)) {
    jsonResponse(false, 'Nessun campo da aggiornare', [], 400);
}

$valori[] = $idUtente;
$pdo      = getConnection();
$stmt     = $pdo->prepare("UPDATE Utente SET " . implode(', ', $campi) . " WHERE IdUtente = ?");
$stmt->execute($valori);

if ($stmt->rowCount() === 0) {
    jsonResponse(false, 'Utente non trovato o nessuna modifica effettuata', [], 404);
}

jsonResponse(true, 'Utente aggiornato con successo');
