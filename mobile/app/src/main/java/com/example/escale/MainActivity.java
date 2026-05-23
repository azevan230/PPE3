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
        NavireAdapter adapter = new NavireAdapter(this, naviresList, new NavireAdapter.NavireActionListener() {
            @Override
            public void onDemande(JSONObject navire) {
                ouvrirDialogueEscale(navire);
            }

            @Override
            public void onClickItem(JSONObject navire) {
                ouvrirDetailsNavire(navire);
            }
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
            DatePickerDialog dp = new DatePickerDialog(this, (view, y, m, d) -> {
                dateArrive[0] = String.format("%04d-%02d-%02d", y, m + 1, d);
                txtArrive.setText(dateArrive[0]);
                dateDepart[0] = ""; // reset si on rechange l'arrivée
                txtDepart.setText("Non sélectionnée");
            }, c.get(Calendar.YEAR), c.get(Calendar.MONTH), c.get(Calendar.DAY_OF_MONTH));
            dp.getDatePicker().setMinDate(System.currentTimeMillis()); // bloque le passé
            dp.show();
        });

        // Sélecteur date départ
        btnDepart.setOnClickListener(v -> {
            if (dateArrive[0].isEmpty()) {
                Toast.makeText(this, "Choisis d'abord la date d'arrivée", Toast.LENGTH_SHORT).show();
                return;
            }
            Calendar c = Calendar.getInstance();
            // Parse la date d'arrivée pour fixer le min du départ
            String[] parts = dateArrive[0].split("-");
            Calendar minDep = Calendar.getInstance();
            minDep.set(Integer.parseInt(parts[0]), Integer.parseInt(parts[1]) - 1, Integer.parseInt(parts[2]));
            minDep.add(Calendar.DAY_OF_MONTH, 1); // au moins le lendemain

            DatePickerDialog dp = new DatePickerDialog(this, (view, y, m, d) -> {
                dateDepart[0] = String.format("%04d-%02d-%02d", y, m + 1, d);
                txtDepart.setText(dateDepart[0]);
            }, minDep.get(Calendar.YEAR), minDep.get(Calendar.MONTH), minDep.get(Calendar.DAY_OF_MONTH));
            dp.getDatePicker().setMinDate(minDep.getTimeInMillis());
            dp.show();
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

    // ── Dialogue de détails du navire ──────────────────────────────────────

    private void ouvrirDetailsNavire(JSONObject navire) {
        View view = getLayoutInflater().inflate(R.layout.dialog_navire_details, null);

        try {
            // En-tête
            ((TextView) view.findViewById(R.id.dlgNom))
                    .setText(navire.optString("nom", "—"));
            ((TextView) view.findViewById(R.id.dlgType))
                    .setText(navire.optString("type_navire", "Type non spécifié"));

            // Identification
            ((TextView) view.findViewById(R.id.dlgLloyds))
                    .setText("N° Lloyds : " + navire.optString("num_lloyds", "Non renseigné"));
            ((TextView) view.findViewById(R.id.dlgPavillon))
                    .setText("🏳 Pavillon : " + navire.optString("pavillon", "Non renseigné"));
            String portNom = navire.optString("port_attache_nom", "");
            if (portNom.isEmpty()) {
                portNom = navire.optString("port_nom", "—");
            }
            ((TextView) view.findViewById(R.id.dlgPort))
                    .setText("🏠 Port d'attache : " + portNom);

            // Caractéristiques
            ((TextView) view.findViewById(R.id.dlgLongueur))
                    .setText("↔ Longueur : " + navire.optString("longueur", "—") + " m");
            ((TextView) view.findViewById(R.id.dlgLargeur))
                    .setText("↕ Largeur : " + navire.optString("largeur", "—") + " m");
            ((TextView) view.findViewById(R.id.dlgTirantEau))
                    .setText("🌊 Tirant d'eau : " + navire.optString("tirant_eau", "—") + " m");
            ((TextView) view.findViewById(R.id.dlgCapacite))
                    .setText("📦 Capacité : " + navire.optString("capacite", "—") + " EVP");

            // Équipements
            boolean prop = navire.optBoolean("propulseur", false);
            boolean remo = navire.optBoolean("remorqueur", false);
            boolean auto = navire.optBoolean("autorise", false);

            ((TextView) view.findViewById(R.id.dlgPropulseur))
                    .setText((prop ? "✅" : "❌") + " Propulseur d'étrave");
            ((TextView) view.findViewById(R.id.dlgRemorqueur))
                    .setText((remo ? "✅" : "❌") + " Remorqueur requis");
            ((TextView) view.findViewById(R.id.dlgAutorise))
                    .setText((auto ? "✅" : "❌") + " Autorisé au port");

            // Fret
            ((TextView) view.findViewById(R.id.dlgFret))
                    .setText(navire.optString("fret_type", "—")
                            + " — " + navire.optString("fret_libelle", "—"));

            // Escale (visible seulement si applicable)
            boolean enEscale = navire.optBoolean("en_escale", false);
            boolean enAttente = navire.optBoolean("en_attente", false);

            if (enEscale || enAttente) {
                view.findViewById(R.id.dlgSectionEscale).setVisibility(View.VISIBLE);

                ((TextView) view.findViewById(R.id.dlgEscaleStatut))
                        .setText("Statut : " + navire.optString("statut", "—"));
                ((TextView) view.findViewById(R.id.dlgEscaleArrivee))
                        .setText("📅 Arrivée prévue : " + navire.optString("escale_date_arrive", "—"));
                ((TextView) view.findViewById(R.id.dlgEscaleDepart))
                        .setText("📅 Départ prévu : " + navire.optString("escale_date_depart", "—"));
            }

        } catch (Exception e) {
            Toast.makeText(this, "Erreur d'affichage des détails", Toast.LENGTH_SHORT).show();
            return;
        }

        new AlertDialog.Builder(this)
                .setView(view)
                .setPositiveButton("Fermer", null)
                .show();
    }

    // ── Déconnexion ────────────────────────────────────────────────────────

    private void deconnecter() {
        api.deconnecter();
        startActivity(new Intent(this, LoginActivity.class));
        finish();
    }
}