<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$pdo  = getConnection();
$stmt = $pdo->query("
    SELECT 
        n.IdNotifica,
        n.Titolo,
        n.Messaggio,
        n.DataOra,
        n.Destinatario_IdUtente,
        u.Nome AS NomeDestinatario,
        u.Cognome AS CognomeDestinatario
    FROM Notifica n
    LEFT JOIN Utente u ON u.IdUtente = n.Destinatario_IdUtente
    ORDER BY n.DataOra DESC
");
$notifiche = $stmt->fetchAll();

jsonResponse(true, 'Lista notifiche recuperata', ['notifiche' => $notifiche]);
