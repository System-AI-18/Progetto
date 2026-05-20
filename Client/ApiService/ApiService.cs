using Client.ApiService.Models;
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

        static async Task LoginAsync(string nome, string cognome)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(new { Nome = nome, Cognome = cognome }), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await sharedClient.PostAsync("utente/login.php", stringContent);

            var jsonResponse = await response.Content.ReadAsStringAsync();

            LoginResponse? user = JsonSerializer.Deserialize<LoginResponse>(jsonResponse);

            if (!user.Success || user is null) { return; }

            else
            {
                Sessione.ruolo = user.Utente.Ruolo;
                Sessione.token = user.Token;

                sharedClient.DefaultRequestHeaders.Authorization = new System.Net.Http.Headers.AuthenticationHeaderValue("Bearer", user.Token);
            }

        }
        static async Task GetUtenteAsync(int? id)
        {
            using HttpResponseMessage response = await sharedClient.GetAsync($"utente/get.php?id={id}");

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();
            Console.WriteLine($"{jsonResponse}\n");
        }

        static async Task CreateUtenteAsync(Utente? utente)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(utente), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await sharedClient.PostAsync("utente/create.php", stringContent);

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();

            Console.WriteLine($"{jsonResponse}\n");

        }

        static async Task UpdateUtenteAsync(Utente? utente)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(utente), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await sharedClient.PutAsync("utente/update.php", stringContent);

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();

            Console.WriteLine($"{jsonResponse}\n");
        }

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

    }
}