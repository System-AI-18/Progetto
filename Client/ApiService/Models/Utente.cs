public record class Utente
(
    int? IdUtente = null,
    string? Nome = null,
    string? Cognome = null,
    string? Ruolo = null,
    string? Citta = null,
    string? Sesso = null,
    DateOnly? DataNascita = null,
    int? Client_IdClient = null,
    int? SaldoWallet = null
);