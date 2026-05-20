namespace Client.ApiService
{
    public record class Comunica
    (
     int? Client_IdClient = null,
     int? Server_IdServer = null,
     DateTime? DataOra = null,
     string? NomeClient = null,
     string? NomeServer = null
    );
}
