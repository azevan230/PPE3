package com.example.escale;

import android.app.DatePickerDialog;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class MainActivity extends AppCompatActivity {

    private ListView listNavires;
    private ApiClient api;
    private List<JSONObject> naviresList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        api = new ApiClient(this);
        listNavires = findViewById(R.id.listNavires);

        findViewById(R.id.btnDeconnexion).setOnClickListener(v -> deconnecter());

        chargerNavires();
    }

    // ── Charge les navires depuis l'API ────────────────────────────────────

    private void chargerNavires() {
        api.voirNavires(new ApiClient.ApiCallback() {
            @Override
            public void onSucces(JSONObject reponse) {
                runOnUiThread(() -> {
                    try {
                        JSONArray navires = reponse.getJSONArray("navires");
                        naviresList.clear();
                        for (int i = 0; i < navires.length(); i++) {
                            naviresList.add(navires.getJSONObject(i));
                        }
                        afficherNavires();
                    } catch (Exception e) {
                        Toast.makeText(MainActivity.this, "Erreur d'affichage", Toast.LENGTH_SHORT).show();
                    }
                });
            }

            @Override
            public void onErreur(String message) {
                runOnUiThread(() ->
                        Toast.makeText(MainActivity.this, message, Toast.LENGTH_LONG).show()
                );
            }
        });
    }

    // ── Remplit la ListView ────────────────────────────────────────────────

    private void afficherNavires() {
        NavireAdapter adapter = new NavireAdapter(this, naviresList, (navire) -> {
            // Callback quand on clique "Demander une escale"
            ouvrirDialogueEscale(navire);
        });
        listNavires.setAdapter(adapter);
    }

    // ── Dialogue de demande d'escale ───────────────────────────────────────

    private void ouvrirDialogueEscale(JSONObject navire) {
        // Utilise un tableau pour stocker les dates sélectionnées
        final String[] dateArrive = {""};
        final String[] dateDepart = {""};

        AlertDialog.Builder builder = new AlertDialog.Builder(this);

        try {
            builder.setTitle("Escale — " + navire.getString("nom"));
        } catch (Exception e) {
            builder.setTitle("Demande d'escale");
        }

        View dialogView = getLayoutInflater().inflate(R.layout.dialog_escale, null);
        builder.setView(dialogView);

        TextView txtArrive = dialogView.findViewById(R.id.txtDateArrive);
        TextView txtDepart = dialogView.findViewById(R.id.txtDateDepart);
        Button btnArrive   = dialogView.findViewById(R.id.btnPickArrive);
        Button btnDepart   = dialogView.findViewById(R.id.btnPickDepart);

        // Sélecteur date arrivée
        btnArrive.setOnClickListener(v -> {
            Calendar c = Calendar.getInstance();
            new DatePickerDialog(this, (view, y, m, d) -> {
                dateArrive[0] = String.format("%04d-%02d-%02d", y, m + 1, d);
                txtArrive.setText(dateArrive[0]);
            }, c.get(Calendar.YEAR), c.get(Calendar.MONTH), c.get(Calendar.DAY_OF_MONTH)).show();
        });

        // Sélecteur date départ
        btnDepart.setOnClickListener(v -> {
            Calendar c = Calendar.getInstance();
            new DatePickerDialog(this, (view, y, m, d) -> {
                dateDepart[0] = String.format("%04d-%02d-%02d", y, m + 1, d);
                txtDepart.setText(dateDepart[0]);
            }, c.get(Calendar.YEAR), c.get(Calendar.MONTH), c.get(Calendar.DAY_OF_MONTH)).show();
        });

        builder.setPositiveButton("Envoyer", (dialog, which) -> {
            if (dateArrive[0].isEmpty() || dateDepart[0].isEmpty()) {
                Toast.makeText(this, "Sélectionne les deux dates", Toast.LENGTH_SHORT).show();
                return;
            }

            try {
                int idNavire = navire.getInt("id_navire");
                api.demanderEscale(idNavire, dateArrive[0], dateDepart[0], new ApiClient.ApiCallback() {
                    @Override
                    public void onSucces(JSONObject reponse) {
                        runOnUiThread(() -> {
                            Toast.makeText(MainActivity.this,
                                    "Demande envoyée, en attente de validation",
                                    Toast.LENGTH_LONG).show();
                            chargerNavires(); // Rafraîchit la liste
                        });
                    }

                    @Override
                    public void onErreur(String message) {
                        runOnUiThread(() ->
                                Toast.makeText(MainActivity.this, message, Toast.LENGTH_LONG).show()
                        );
                    }
                });
            } catch (Exception e) {
                Toast.makeText(this, "Erreur", Toast.LENGTH_SHORT).show();
            }
        });

        builder.setNegativeButton("Annuler", null);
        builder.show();
    }

    // ── Déconnexion ────────────────────────────────────────────────────────

    private void deconnecter() {
        api.deconnecter();
        startActivity(new Intent(this, LoginActivity.class));
        finish();
    }
}