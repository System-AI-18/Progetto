<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('GET');

$idUtente = (int)$tokenPayload->idUtente;

$pdo  = getConnection();

// Recupera eventi destinati all'utente o a tutti, con la risposta dell'utente se presente
$stmt = $pdo->prepare("
    SELECT 
        e.IdEvento,
        e.Titolo,
        e.Descrizione,
        e.DataOra,
        e.Scadenza,
        re.Risposta
    FROM Evento e
    LEFT JOIN RispostaEvento re 
        ON re.Evento_IdEvento = e.IdEvento 
        AND re.Utente_IdUtente = ?
    WHERE e.Destinatario_IdUtente = ? OR e.Destinatario_IdUtente IS NULL
    ORDER BY e.DataOra DESC
");
$stmt->execute([$idUtente, $idUtente]);
$eventi = $stmt->fetchAll();

jsonResponse(true, 'Eventi recuperati', ['eventi' => $eventi]);
