<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/auth.php';

$tokenPayload = requireAuth();
requireMethod('POST');

$body        = getBody();
$idMittente  = (int)$tokenPayload->idUtente;
$idDest      = isset($body['Destinatario_IdUtente']) ? (int)$body['Destinatario_IdUtente'] : 0;
$importo     = isset($body['Importo']) ? (float)$body['Importo'] : 0;
$descrizione = trim($body['Descrizione'] ?? '');

if ($idDest <= 0) {
    jsonResponse(false, 'Destinatario non valido', [], 400);
}

if ($importo <= 0) {
    jsonResponse(false, 'Importo deve essere maggiore di zero', [], 400);
}

if ($idMittente === $idDest) {
    jsonResponse(false, 'Non puoi inviare token a te stesso', [], 400);
}

$pdo = getConnection();

// Verifica saldo mittente
$stmt = $pdo->prepare("SELECT SaldoWallet FROM Utente WHERE IdUtente = ?");
$stmt->execute([$idMittente]);
$mittente = $stmt->fetch();

if (!$mittente) {
    jsonResponse(false, 'Mittente non trovato', [], 404);
}

if ($mittente['SaldoWallet'] < $importo) {
    jsonResponse(false, 'Saldo insufficiente', [], 400);
}

// Verifica che il destinatario esista
$stmtDest = $pdo->prepare("SELECT IdUtente FROM Utente WHERE IdUtente = ?");
$stmtDest->execute([$idDest]);
if (!$stmtDest->fetch()) {
    jsonResponse(false, 'Destinatario non trovato', [], 404);
}

// Transazione atomica — o va tutto bene o non cambia niente
$pdo->beginTransaction();

try {
    // Scala dal mittente
    $pdo->prepare("UPDATE Utente SET SaldoWallet = SaldoWallet - ? WHERE IdUtente = ?")
        ->execute([$importo, $idMittente]);

    // Aggiunge al destinatario
    $pdo->prepare("UPDATE Utente SET SaldoWallet = SaldoWallet + ? WHERE IdUtente = ?")
        ->execute([$importo, $idDest]);

    // Registra la transazione
    $pdo->prepare("
        INSERT INTO Transazione (Mittente_IdUtente, Destinatario_IdUtente, Importo, Descrizione, DataOra)
        VALUES (?, ?, ?, ?, NOW())
    ")->execute([$idMittente, $idDest, $importo, $descrizione ?: null]);

    $pdo->commit();
    jsonResponse(true, 'Trasferimento effettuato con successo');

} catch (Exception $e) {
    $pdo->rollBack();
    jsonResponse(false, 'Errore durante il trasferimento', [], 500);
}
