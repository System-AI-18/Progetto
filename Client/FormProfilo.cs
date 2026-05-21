using Client.ApiService;

namespace Client
{
    public partial class FormProfilo : Form
    {
        public FormProfilo()
        {
            InitializeComponent();

        }

        private void FormProfilo_Shown(object sender, EventArgs e)
        {
            lblTesto.Text = Sessione.nome;
            lblTesto1.Text = Sessione.cognome;

        }
        private async void lblTesto_Click(object sender, EventArgs e)
        {

        }

        private async void lblTesto1_Click(object sender, EventArgs e)
        {

        }
    }
}
