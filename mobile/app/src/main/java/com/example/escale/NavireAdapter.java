package com.example.escale;

import android.content.Context;
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

            boolean enEscale = navire.getBoolean("en_escale");

            if (enEscale) {
                txtEnEscale.setVisibility(View.VISIBLE);
                btnEscale.setVisibility(View.GONE);
            } else {
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