package com.example.escale;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.TextView;

import org.json.JSONObject;

import java.util.List;

public class NavireAdapter extends ArrayAdapter<JSONObject> {

    public interface OnDemandeEscaleListener {
        void onDemande(JSONObject navire);
    }

    private final OnDemandeEscaleListener listener;

    public NavireAdapter(Context context, List<JSONObject> navires, OnDemandeEscaleListener listener) {
        super(context, 0, navires);
        this.listener = listener;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext())
                    .inflate(R.layout.item_navire, parent, false);
        }

        JSONObject navire = getItem(position);

        TextView txtNom      = convertView.findViewById(R.id.txtNomNavire);
        TextView txtFret     = convertView.findViewById(R.id.txtFret);
        TextView txtEnEscale = convertView.findViewById(R.id.txtEnEscale);
        Button   btnEscale   = convertView.findViewById(R.id.btnDemanderEscale);

        try {
            txtNom.setText(navire.getString("nom"));
            txtFret.setText(navire.getString("fret_type") + " — " + navire.getString("fret_libelle"));

            // Récupère le statut renvoyé par l'API :
            //   "Disponible" / "En escale" / "Escale prévue" / "Demande en attente"
            String statut     = navire.optString("statut", "Disponible");
            boolean enEscale  = navire.optBoolean("en_escale", false);
            boolean enAttente = navire.optBoolean("en_attente", false);

            if (enEscale || enAttente) {
                // Afficher le statut, masquer le bouton
                txtEnEscale.setVisibility(View.VISIBLE);
                btnEscale.setVisibility(View.GONE);
                txtEnEscale.setText(statut);

                // Couleur différente selon le statut
                if (enAttente) {
                    txtEnEscale.setTextColor(Color.parseColor("#BA7517")); // ambre/orange
                } else {
                    txtEnEscale.setTextColor(Color.parseColor("#0F6E56")); // teal/vert
                }
            } else {
                // Disponible -> afficher le bouton
                txtEnEscale.setVisibility(View.GONE);
                btnEscale.setVisibility(View.VISIBLE);
                btnEscale.setOnClickListener(v -> listener.onDemande(navire));
            }

        } catch (Exception e) {
            txtNom.setText("Erreur d'affichage");
        }

        return convertView;
    }
}