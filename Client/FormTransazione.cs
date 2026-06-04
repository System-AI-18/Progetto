using Client.ApiService;
using Client.ApiService.Models;

namespace Client
{
    public partial class FormTransazione : Form
    {
        public FormTransazione()
        {
            InitializeComponent();
        }

        private async void btnInvia_Click(object sender, EventArgs e)
        {

            if (!int.TryParse(tBoxDestinatario.Text, out int idDestinatario))
            {
                MessageBox.Show("Inserisci un ID destinatario valido.");
                return;
            }

            if (!int.TryParse(tBoxImporto.Text, out int importo))
            {
                MessageBox.Show("Inserisci un importo valido.");
                return;
            }


            if (importo <= 0)
            {
                MessageBox.Show("L'importo deve essere maggiore di zero.");
                return;
            }


            Transazioni datiTransazione = new();
            datiTransazione.idDestinatario = idDestinatario;
            datiTransazione.importo = importo;
            datiTransazione.descrizione = tBoxDescrizione.Text;


            try
            {

                btnInvia.Enabled = false;

                await ApiService.ApiService.InviaSaldoAsync(datiTransazione);

                MessageBox.Show("Transazione completata con successo!");
            }
            catch (Exception ex)
            {
                MessageBox.Show("Errore durante l'invio: " + ex.Message);
            }
            finally
            {

                btnInvia.Enabled = true;
            }
        }


        private void FormTransazioni_Shown(object sender, EventArgs e)
        {

            lbl_idMittente.Text = Sessione.idUtente.ToString();
        }


    }
}