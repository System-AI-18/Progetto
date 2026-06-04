namespace Client
{
    partial class FormTransazione
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            lblMittente = new Label();
            lblImporto = new Label();
            tBoxImporto = new TextBox();
            tBoxDestinatario = new TextBox();
            lblDestinatario = new Label();
            btnInvia = new Button();
            lbl_idMittente = new Label();
            tBoxDescrizione = new TextBox();
            lblDescrizione = new Label();
            SuspendLayout();
            // 
            // lblMittente
            // 
            lblMittente.AutoSize = true;
            lblMittente.Location = new Point(171, 69);
            lblMittente.Name = "lblMittente";
            lblMittente.Size = new Size(52, 15);
            lblMittente.TabIndex = 0;
            lblMittente.Text = "Mittente";
            // 
            // lblImporto
            // 
            lblImporto.AutoSize = true;
            lblImporto.Location = new Point(171, 142);
            lblImporto.Name = "lblImporto";
            lblImporto.Size = new Size(50, 15);
            lblImporto.TabIndex = 4;
            lblImporto.Text = "Importo";
            // 
            // tBoxImporto
            // 
            tBoxImporto.Location = new Point(286, 139);
            tBoxImporto.Name = "tBoxImporto";
            tBoxImporto.Size = new Size(100, 23);
            tBoxImporto.TabIndex = 5;
            // 
            // tBoxDestinatario
            // 
            tBoxDestinatario.Location = new Point(286, 100);
            tBoxDestinatario.Name = "tBoxDestinatario";
            tBoxDestinatario.Size = new Size(100, 23);
            tBoxDestinatario.TabIndex = 3;
            // 
            // lblDestinatario
            // 
            lblDestinatario.AutoSize = true;
            lblDestinatario.Location = new Point(171, 103);
            lblDestinatario.Name = "lblDestinatario";
            lblDestinatario.Size = new Size(70, 15);
            lblDestinatario.TabIndex = 1;
            lblDestinatario.Text = "Destinatario";
            // 
            // btnInvia
            // 
            btnInvia.Location = new Point(286, 246);
            btnInvia.Name = "btnInvia";
            btnInvia.Size = new Size(75, 23);
            btnInvia.TabIndex = 6;
            btnInvia.Text = "Invia";
            btnInvia.UseVisualStyleBackColor = true;
            btnInvia.Click += btnInvia_Click;
            // 
            // lbl_idMittente
            // 
            lbl_idMittente.AutoSize = true;
            lbl_idMittente.Location = new Point(286, 69);
            lbl_idMittente.Name = "lbl_idMittente";
            lbl_idMittente.Size = new Size(52, 15);
            lbl_idMittente.TabIndex = 7;
            lbl_idMittente.Text = "IdUtente";
            // 
            // tBoxDescrizione
            // 
            tBoxDescrizione.Location = new Point(286, 186);
            tBoxDescrizione.Name = "tBoxDescrizione";
            tBoxDescrizione.Size = new Size(100, 23);
            tBoxDescrizione.TabIndex = 8;
            // 
            // lblDescrizione
            // 
            lblDescrizione.AutoSize = true;
            lblDescrizione.Location = new Point(178, 191);
            lblDescrizione.Name = "lblDescrizione";
            lblDescrizione.Size = new Size(67, 15);
            lblDescrizione.TabIndex = 9;
            lblDescrizione.Text = "Descrizione";
            // 
            // FormTransazione
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(800, 450);
            Controls.Add(lblDescrizione);
            Controls.Add(tBoxDescrizione);
            Controls.Add(lbl_idMittente);
            Controls.Add(btnInvia);
            Controls.Add(tBoxImporto);
            Controls.Add(lblImporto);
            Controls.Add(tBoxDestinatario);
            Controls.Add(lblDestinatario);
            Controls.Add(lblMittente);
            Name = "FormTransazione";
            Text = "FormTransazione";
            Shown += FormTransazioni_Shown;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label lblMittente;
        private Label lblImporto;
        private TextBox tBoxImporto;
        private TextBox tBoxDestinatario;
        private Label lblDestinatario;
        private Button btnInvia;
        private Label lbl_idMittente;
        private TextBox tBoxDescrizione;
        private Label lblDescrizione;
    }
}