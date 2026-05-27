<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('POST');

$body       = getBody();
$idNotifica = isset($body['IdNotifica']) ? (int)$body['IdNotifica'] : 0;
$idUtente   = (int)$tokenPayload->idUtente;

if ($idNotifica <= 0) {
    jsonResponse(false, 'ID notifica non valido', [], 400);
}

$pdo  = getConnection();

// Inserisce solo se non è già stata segnata come letta
$stmt = $pdo->prepare("
    INSERT IGNORE INTO NotificaLetta (Notifica_IdNotifica, Utente_IdUtente, DataLettura)
    VALUES (?, ?, NOW())
");
$stmt->execute([$idNotifica, $idUtente]);

jsonResponse(true, 'Notifica segnata come letta');
