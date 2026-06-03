<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireRole($tokenPayload, 'amministratore');
requireMethod('GET');

$idEvento = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($idEvento <= 0) {
    jsonResponse(false, 'ID evento non valido', [], 400);
}

$pdo  = getConnection();
$stmt = $pdo->prepare("
    SELECT 
        re.Risposta,
        re.DataRisposta,
        u.IdUtente,
        u.Nome,
        u.Cognome
    FROM RispostaEvento re
    INNER JOIN Utente u ON u.IdUtente = re.Utente_IdUtente
    WHERE re.Evento_IdEvento = ?
    ORDER BY re.DataRisposta DESC
");
$stmt->execute([$idEvento]);
$risposte = $stmt->fetchAll();

jsonResponse(true, 'Risposte recuperate', ['risposte' => $risposte]);
