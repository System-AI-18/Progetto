<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$pdo  = getConnection();
$stmt = $pdo->query("
    SELECT 
        e.IdEvento,
        e.Titolo,
        e.Descrizione,
        e.DataOra,
        e.Scadenza,
        e.Destinatario_IdUtente,
        u.Nome AS NomeDestinatario,
        u.Cognome AS CognomeDestinatario
    FROM Evento e
    LEFT JOIN Utente u ON u.IdUtente = e.Destinatario_IdUtente
    ORDER BY e.DataOra DESC
");
$eventi = $stmt->fetchAll();

jsonResponse(true, 'Lista eventi recuperata', ['eventi' => $eventi]);
