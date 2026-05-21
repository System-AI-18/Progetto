namespace Client
{
    partial class FormProfilo
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
            label1 = new Label();
            lblNome = new Label();
            lblTesto = new Label();
            lblCognome = new Label();
            lblTesto1 = new Label();
            SuspendLayout();
            // 
            // label1
            // 
            label1.Location = new Point(0, 0);
            label1.Name = "label1";
            label1.Size = new Size(100, 23);
            label1.TabIndex = 0;
            // 
            // lblNome
            // 
            lblNome.AutoSize = true;
            lblNome.Location = new Point(108, 69);
            lblNome.Name = "lblNome";
            lblNome.Size = new Size(40, 15);
            lblNome.TabIndex = 1;
            lblNome.Text = "Nome";
            // 
            // lblTesto
            // 
            lblTesto.AutoSize = true;
            lblTesto.Location = new Point(192, 69);
            lblTesto.Name = "lblTesto";
            lblTesto.Size = new Size(35, 15);
            lblTesto.TabIndex = 2;
            lblTesto.Text = "Testo";
            lblTesto.Click += lblTesto_Click;
            // 
            // lblCognome
            // 
            lblCognome.AutoSize = true;
            lblCognome.Location = new Point(108, 108);
            lblCognome.Name = "lblCognome";
            lblCognome.Size = new Size(60, 15);
            lblCognome.TabIndex = 3;
            lblCognome.Text = "Cognome";
            // 
            // lblTesto1
            // 
            lblTesto1.AutoSize = true;
            lblTesto1.Location = new Point(192, 108);
            lblTesto1.Name = "lblTesto1";
            lblTesto1.Size = new Size(35, 15);
            lblTesto1.TabIndex = 4;
            lblTesto1.Text = "Testo";
            lblTesto1.Click += lblTesto1_Click;
            // 
            // FormProfilo
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(800, 450);
            Controls.Add(lblTesto1);
            Controls.Add(lblCognome);
            Controls.Add(lblTesto);
            Controls.Add(lblNome);
            Controls.Add(label1);
            Name = "FormProfilo";
            Text = "FormProfilo";
            FormClosed += FormProfilo_FormClosed;
            Shown += FormProfilo_Shown;
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label label1;
        private Label lblNome;
        private Label lblTesto;
        private Label lblCognome;
        private Label lblTesto1;
    }
}