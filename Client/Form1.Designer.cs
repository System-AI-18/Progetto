namespace Client
{
    partial class FormLogin
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
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
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            lblName = new Label();
            tBoxName = new TextBox();
            lblCognome = new Label();
            tBoxCognome = new TextBox();
            btnLogin = new Button();
            SuspendLayout();
            // 
            // lblName
            // 
            lblName.AutoSize = true;
            lblName.Location = new Point(99, 63);
            lblName.Name = "lblName";
            lblName.Size = new Size(39, 15);
            lblName.TabIndex = 0;
            lblName.Text = "Name";
            // 
            // tBoxName
            // 
            tBoxName.Location = new Point(183, 63);
            tBoxName.Name = "tBoxName";
            tBoxName.Size = new Size(100, 23);
            tBoxName.TabIndex = 1;
            tBoxName.TextChanged += tBoxName_TextChanged;
            // 
            // lblCognome
            // 
            lblCognome.AutoSize = true;
            lblCognome.Location = new Point(99, 119);
            lblCognome.Name = "lblCognome";
            lblCognome.Size = new Size(60, 15);
            lblCognome.TabIndex = 2;
            lblCognome.Text = "Cognome";
            // 
            // tBoxCognome
            // 
            tBoxCognome.Location = new Point(183, 119);
            tBoxCognome.Name = "tBoxCognome";
            tBoxCognome.Size = new Size(100, 23);
            tBoxCognome.TabIndex = 3;
            tBoxCognome.TextChanged += tBoxCognome_TextChanged;
            // 
            // btnLogin
            // 
            btnLogin.Location = new Point(183, 194);
            btnLogin.Name = "btnLogin";
            btnLogin.Size = new Size(75, 23);
            btnLogin.TabIndex = 4;
            btnLogin.Text = "Login";
            btnLogin.UseVisualStyleBackColor = true;
            btnLogin.Click += btnLogin_Click;
            // 
            // FormLogin
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(766, 440);
            Controls.Add(btnLogin);
            Controls.Add(tBoxCognome);
            Controls.Add(lblCognome);
            Controls.Add(tBoxName);
            Controls.Add(lblName);
            Name = "FormLogin";
            Text = "Form1";
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label lblName;
        private TextBox tBoxName;
        private Label lblCognome;
        private TextBox tBoxCognome;
        private Button btnLogin;
    }
}
