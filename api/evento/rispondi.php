<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('POST');

$body     = getBody();
$idEvento = isset($body['IdEvento']) ? (int)$body['IdEvento'] : 0;
$risposta = trim($body['Risposta'] ?? '');
$idUtente = (int)$tokenPayload->idUtente;

if ($idEvento <= 0) {
    jsonResponse(false, 'ID evento non valido', [], 400);
}

if (!in_array($risposta, ['accettato', 'rifiutato'])) {
    jsonResponse(false, 'Risposta non valida — usa "accettato" o "rifiutato"', [], 400);
}

$pdo = getConnection();

// Verifica che l'evento non sia scaduto
$stmtEvento = $pdo->prepare("SELECT Scadenza FROM Evento WHERE IdEvento = ?");
$stmtEvento->execute([$idEvento]);
$evento = $stmtEvento->fetch();

if (!$evento) {
    jsonResponse(false, 'Evento non trovato', [], 404);
}

if ($evento['Scadenza'] && strtotime($evento['Scadenza']) < time()) {
    jsonResponse(false, 'Evento scaduto, non è più possibile rispondere', [], 400);
}

// Inserisce o aggiorna la risposta
$stmt = $pdo->prepare("
    INSERT INTO RispostaEvento (Evento_IdEvento, Utente_IdUtente, Risposta, DataRisposta)
    VALUES (?, ?, ?, NOW())
    ON DUPLICATE KEY UPDATE Risposta = VALUES(Risposta), DataRisposta = NOW()
");
$stmt->execute([$idEvento, $idUtente, $risposta]);

jsonResponse(true, 'Risposta registrata con successo');
