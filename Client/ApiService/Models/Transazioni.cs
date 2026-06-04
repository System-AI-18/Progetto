namespace Client.ApiService.Models
{
    public record class Transazioni
    (
        int? idMittente,
        int? idDestinatario,
        int? importo,
        string? descrizione

        );
}
