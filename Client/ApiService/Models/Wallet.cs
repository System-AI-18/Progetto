namespace Client.ApiService.Models
{
    public record class Wallet
    (
        int Destinatario_IdUtente,
        decimal Importo,
        string? Descrizione = null,
        bool Success = false,
        string? Message = null
    );
}