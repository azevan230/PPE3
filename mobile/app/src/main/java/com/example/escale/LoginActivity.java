package com.example.escale;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class LoginActivity extends AppCompatActivity {

    private EditText editLogin, editMdp;
    private Button btnConnexion;
    private TextView txtErreur;
    private ApiClient api;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        api = new ApiClient(this);

        editLogin    = findViewById(R.id.editLogin);
        editMdp      = findViewById(R.id.editMdp);
        btnConnexion = findViewById(R.id.btnConnexion);
        txtErreur    = findViewById(R.id.txtErreur);

        btnConnexion.setOnClickListener(v -> {
            String login = editLogin.getText().toString().trim();
            String mdp   = editMdp.getText().toString().trim();

            if (login.isEmpty() || mdp.isEmpty()) {
                txtErreur.setText("Remplis tous les champs");
                txtErreur.setVisibility(View.VISIBLE);
                return;
            }

            btnConnexion.setEnabled(false);
            txtErreur.setVisibility(View.GONE);

            api.connecter(login, mdp, new ApiClient.ApiCallback() {
                @Override
                public void onSucces(org.json.JSONObject reponse) {
                    // Aller sur l'écran principal
                    runOnUiThread(() -> {
                        startActivity(new Intent(LoginActivity.this, MainActivity.class));
                        finish(); // empêche de revenir en arrière sur le login
                    });
                }

                @Override
                public void onErreur(String message) {
                    runOnUiThread(() -> {
                        txtErreur.setText(message);
                        txtErreur.setVisibility(View.VISIBLE);
                        btnConnexion.setEnabled(true);
                    });
                }
            });
        });
    }
}
