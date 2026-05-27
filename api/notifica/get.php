<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('GET');

$idUtente = (int)$tokenPayload->idUtente;

$pdo  = getConnection();

// Recupera notifiche destinate all'utente o a tutti (Destinatario NULL)
$stmt = $pdo->prepare("
    SELECT 
        n.IdNotifica,
        n.Titolo,
        n.Messaggio,
        n.DataOra,
        CASE WHEN nl.Utente_IdUtente IS NOT NULL THEN 1 ELSE 0 END AS Letta
    FROM Notifica n
    LEFT JOIN NotificaLetta nl 
        ON nl.Notifica_IdNotifica = n.IdNotifica 
        AND nl.Utente_IdUtente = ?
    WHERE n.Destinatario_IdUtente = ? OR n.Destinatario_IdUtente IS NULL
    ORDER BY n.DataOra DESC
");
$stmt->execute([$idUtente, $idUtente]);
$notifiche = $stmt->fetchAll();

jsonResponse(true, 'Notifiche recuperate', ['notifiche' => $notifiche]);
