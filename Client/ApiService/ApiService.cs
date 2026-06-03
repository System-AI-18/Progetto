using Client.ApiService.Models;
using System.Text;
using System.Text.Json;

namespace Client.ApiService
{
    public class ApiService
    {
        private static HttpClient sharedClient = new HttpClient()
        {
            BaseAddress = new Uri("http://192.168.1.50/api/"),
        };

        public static async Task LoginAsync(string nome, string cognome)
        {
            using StringContent stringContent = new(JsonSerializer.Serialize(new { Nome = nome, Cognome = cognome }), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await sharedClient.PostAsync("utente/login.php", stringContent);

            var jsonResponse = await response.Content.ReadAsStringAsync();

            var options = new JsonSerializerOptions { PropertyNameCaseInsensitive = true };
            LoginResponse? user = JsonSerializer.Deserialize<LoginResponse>(jsonResponse, options);

            if (user is null || !user.Success) { return; }

            else
            {
                Sessione.ruolo = user.Utente.Ruolo;
                Sessione.token = user.Token;
                Sessione.nome = user.Utente.Nome;
                Sessione.cognome = user.Utente.Cognome;


                sharedClient.DefaultRequestHeaders.Authorization = new System.Net.Http.Headers.AuthenticationHeaderValue("Bearer", user.Token);

                Console.WriteLine("Hello");
            }

        }
        public static async Task<Utente?> GetUtenteAsync(int? id)
        {
            using HttpResponseMessage response = await sharedClient.GetAsync($"utente/get.php?id={id}");

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();


            ResponseUtente? utente = JsonSerializer.Deserialize<ResponseUtente?>(jsonResponse);

            Console.WriteLine($"{jsonResponse}\n");

            if (utente is null || !utente.Success) { return null; }

            return utente.Utente;
        }

        public static async Task<int?> GetSaldoAsync()
        {
            using HttpResponseMessage response = await sharedClient.GetAsync($"wallet/saldo.php");
            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();

            ResponseUtente? utenteSaldo = JsonSerializer.Deserialize<ResponseUtente>(jsonResponse);

            if (utenteSaldo is null || !utenteSaldo.Success) { return null; }

            return utenteSaldo.Utente.SaldoWallet;


        }

        public static async Task InviaSaldoAsync(Wallet? saldo)
        {

            using StringContent stringContent = new(JsonSerializer.Serialize(saldo), Encoding.UTF8, "application/json");

            using HttpResponseMessage response = await sharedClient.PostAsync("wallet/invia.php", stringContent);

            response.EnsureSuccessStatusCode().WriteRequestToConsole();

            var jsonResponse = await response.Content.ReadAsStringAsync();

            Wallet? utenteSaldo = JsonSerializer.Deserialize<Wallet>(jsonResponse);



        }



        //static async Task CreateUtenteAsync(Utente? utente)
        //{
        //    using StringContent stringContent = new(JsonSerializer.Serialize(utente), Encoding.UTF8, "application/json");

        //    using HttpResponseMessage response = await sharedClient.PostAsync("utente/create.php", stringContent);

        //    response.EnsureSuccessStatusCode().WriteRequestToConsole();

        //    var jsonResponse = await response.Content.ReadAsStringAsync();

        //    Console.WriteLine($"{jsonResponse}\n");

        //}

        //static async Task UpdateUtenteAsync(Utente? utente)
        //{
        //    using StringContent stringContent = new(JsonSerializer.Serialize(utente), Encoding.UTF8, "application/json");

        //    using HttpResponseMessage response = await sharedClient.PutAsync("utente/update.php", stringContent);

        //    response.EnsureSuccessStatusCode().WriteRequestToConsole();

        //    var jsonResponse = await response.Content.ReadAsStringAsync();

        //    Console.WriteLine($"{jsonResponse}\n");
        //}

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