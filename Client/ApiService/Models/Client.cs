namespace Client.ApiService
{
    public record class Client
    (
        int? IdClient = null,
        string? NomeClient = null,
        string? WalletToken = null
    );
}