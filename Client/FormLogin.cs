using Client.ApiService;

namespace Client
{
    public partial class FormLogin : Form
    {
        FormProfilo profilo = new();
        public FormLogin()
        {
            InitializeComponent();
        }

        private void tBoxName_TextChanged(object sender, EventArgs e)
        {

        }
        private void tBoxCognome_TextChanged(object sender, EventArgs e)
        {

        }

        private async void btnLogin_Click(object sender, EventArgs e)
        {
            try
            {

                await ApiService.ApiService.LoginAsync(tBoxName.Text, tBoxCognome.Text);
                if (Sessione.token is null)
                {
                    MessageBox.Show("credenziali non valide");
                    return;
                }
                if (Sessione.ruolo == "amministratore")
                {
                    this.Hide();

                    await profilo.ShowAsync();
                }


            }
            catch (Exception ex)
            {
                MessageBox.Show("Errore di connessione: " + ex.Message);
            }
        }
    }
}