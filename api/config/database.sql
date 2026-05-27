-- ============================================================
-- DATABASE PRINCIPALE
-- ============================================================
CREATE DATABASE IF NOT EXISTS myapp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE myapp;

-- ============================================================
-- CLIENT (dispositivi fisici su cui gira l'app)
-- ============================================================
CREATE TABLE Client (
    IdClient    INT          NOT NULL AUTO_INCREMENT,
    NomeClient  VARCHAR(100) NOT NULL,
    PRIMARY KEY (IdClient)
);

-- ============================================================
-- SERVER
-- ============================================================
CREATE TABLE Server (
    IdServer    INT          NOT NULL AUTO_INCREMENT,
    NomeServer  VARCHAR(100) NOT NULL,
    PRIMARY KEY (IdServer)
);

-- ============================================================
-- UTENTE
-- ============================================================
CREATE TABLE Utente (
    IdUtente        INT          NOT NULL AUTO_INCREMENT,
    Nome            VARCHAR(100) NOT NULL,
    Cognome         VARCHAR(100) NOT NULL,
    Ruolo           ENUM('utente', 'amministratore') NOT NULL DEFAULT 'utente',
    Città           VARCHAR(100),
    Sesso           ENUM('M', 'F', 'Altro'),
    DataNascita     DATE,
    SaldoWallet     DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    Client_IdClient INT,
    PRIMARY KEY (IdUtente),
    FOREIGN KEY (Client_IdClient) REFERENCES Client(IdClient)
);

-- ============================================================
-- TRANSAZIONE WALLET (storico movimenti tra utenti)
-- ============================================================
CREATE TABLE Transazione (
    IdTransazione       INT            NOT NULL AUTO_INCREMENT,
    Mittente_IdUtente   INT            NOT NULL,
    Destinatario_IdUtente INT          NOT NULL,
    Importo             DECIMAL(10, 2) NOT NULL,
    Descrizione         VARCHAR(255),
    DataOra             DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (IdTransazione),
    FOREIGN KEY (Mittente_IdUtente)     REFERENCES Utente(IdUtente),
    FOREIGN KEY (Destinatario_IdUtente) REFERENCES Utente(IdUtente)
);

-- ============================================================
-- NOTIFICA (messaggio informativo inviato dall'admin)
-- ============================================================
CREATE TABLE Notifica (
    IdNotifica      INT          NOT NULL AUTO_INCREMENT,
    Titolo          VARCHAR(200) NOT NULL,
    Messaggio       TEXT         NOT NULL,
    DataOra         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Destinatario_IdUtente INT,         -- NULL = inviata a tutti
    PRIMARY KEY (IdNotifica),
    FOREIGN KEY (Destinatario_IdUtente) REFERENCES Utente(IdUtente)
);

-- ============================================================
-- NOTIFICA LETTA (traccia se l'utente ha letto la notifica)
-- ============================================================
CREATE TABLE NotificaLetta (
    Notifica_IdNotifica INT      NOT NULL,
    Utente_IdUtente     INT      NOT NULL,
    DataLettura         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Notifica_IdNotifica, Utente_IdUtente),
    FOREIGN KEY (Notifica_IdNotifica) REFERENCES Notifica(IdNotifica),
    FOREIGN KEY (Utente_IdUtente)     REFERENCES Utente(IdUtente)
);

-- ============================================================
-- EVENTO (azione da accettare o rifiutare)
-- ============================================================
CREATE TABLE Evento (
    IdEvento        INT          NOT NULL AUTO_INCREMENT,
    Titolo          VARCHAR(200) NOT NULL,
    Descrizione     TEXT,
    DataOra         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Scadenza        DATETIME,            -- entro quando rispondere
    Destinatario_IdUtente INT,           -- NULL = inviato a tutti
    PRIMARY KEY (IdEvento),
    FOREIGN KEY (Destinatario_IdUtente) REFERENCES Utente(IdUtente)
);

-- ============================================================
-- RISPOSTA EVENTO (accettato o rifiutato dall'utente)
-- ============================================================
CREATE TABLE RispostaEvento (
    Evento_IdEvento INT      NOT NULL,
    Utente_IdUtente INT      NOT NULL,
    Risposta        ENUM('accettato', 'rifiutato') NOT NULL,
    DataRisposta    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Evento_IdEvento, Utente_IdUtente),
    FOREIGN KEY (Evento_IdEvento)   REFERENCES Evento(IdEvento),
    FOREIGN KEY (Utente_IdUtente)   REFERENCES Utente(IdUtente)
);

-- ============================================================
-- COMUNICA (log connessioni client-server)
-- ============================================================
CREATE TABLE comunica (
    Client_IdClient INT      NOT NULL,
    Server_IdServer INT      NOT NULL,
    DataOra         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Client_IdClient, Server_IdServer, DataOra),
    FOREIGN KEY (Client_IdClient) REFERENCES Client(IdClient),
    FOREIGN KEY (Server_IdServer) REFERENCES Server(IdServer)
);
