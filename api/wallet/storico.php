<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('GET');

$idUtente = (int)$tokenPayload->idUtente;

$pdo  = getConnection();

// Recupera tutte le transazioni dove l'utente è mittente o destinatario
$stmt = $pdo->prepare("
    SELECT 
        t.IdTransazione,
        t.Importo,
        t.Descrizione,
        t.DataOra,
        m.Nome  AS NomeMittente,
        m.Cognome AS CognomeMittente,
        d.Nome  AS NomeDestinatario,
        d.Cognome AS CognomeDestinatario,
        CASE WHEN t.Mittente_IdUtente = ? THEN 'uscita' ELSE 'entrata' END AS Tipo
    FROM Transazione t
    INNER JOIN Utente m ON m.IdUtente = t.Mittente_IdUtente
    INNER JOIN Utente d ON d.IdUtente = t.Destinatario_IdUtente
    WHERE t.Mittente_IdUtente = ? OR t.Destinatario_IdUtente = ?
    ORDER BY t.DataOra DESC
");
$stmt->execute([$idUtente, $idUtente, $idUtente]);
$transazioni = $stmt->fetchAll();

jsonResponse(true, 'Storico recuperato', ['transazioni' => $transazioni]);
