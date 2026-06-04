using Client.ApiService;

namespace Client
{
    public partial class FormProfilo : Form
    {
        FormTransazione wallet = new();
        public FormProfilo()
        {
            InitializeComponent();

        }

        private void FormProfilo_Shown(object sender, EventArgs e)
        {
            lblTesto.Text = Sessione.nome;
            lblTesto1.Text = Sessione.cognome;

        }
        private void FormProfilo_FormClosed(object sender, FormClosedEventArgs e)
        {
            //  login.Show();
        }

        private async void btnWallet_Click(object sender, EventArgs e)
        {
            try { await wallet.ShowDialogAsync(); }

            catch (Exception ex) { MessageBox.Show("Errore di connessione: " + ex.Message); }
        }
    }
}
