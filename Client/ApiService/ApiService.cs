using System.Text;
using System.Text.Json;

namespace Client.ApiService
{
    internal class ApiService
    {
        private static HttpClient sharedClient = new HttpClient()
        {
            BaseAddress = new Uri("http://192.168.1.50/api/"),
        };


    }

    static class HttpResponseMessageExtensions
    {
        internal static void WriteRequestToConsole(this HttpResponseMessage response)
        {
            if (response is null) { return; }

            var request = response.RequestMessage;
            Console.Write($"{request?.Method}");
            Console.Write($"{request?.RequestUri}");
            Console.Write($"HTTP/{request?.Version}");
        }


        public record class Utente(int? UserId = null, string? Id = null, string? nome = null, string? cognome = null, string? ruolo = null, string? sesso = null, DateOnly? dataNascita = null);
        public record class Client(int? UserId = null, int? Id = null, string? Title = null, bool? Completed = null);
        public record class Server(int? UserId = null, int? Id = null, string? Title = null, bool? Completed = null);

        static async Task GetUtenteAsync(HttpClient httpClient)
        {
            using HttpResponseMessage response = await httpClient.GetAsync("todos/3");

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();
            Console.WriteLine($"{jsonResponse}\n");
        }
        static async Task PostAsync(HttpClient httpClient)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(new { userId = 77, id = 1, title = "write simple code", completed = false }), Encoding.UTF8, "application/json");
            using HttpResponseMessage response = await httpClient.PostAsync("todos", stringContent);

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();
            Console.WriteLine($"{jsonResponse}");
        }

        static async Task PutAsync(HttpClient httpClient)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(new { userId = 1, id = 1, title = "foo bar", completed = false }), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await httpClient.PutAsync("todos", stringContent);

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();

            Console.WriteLine($"{jsonResponse}\n");
        }
    }
}