namespace Client.ApiService.Models
{
    public record class LoginResponse(bool Success, string Token, Utente Utente);
}
