package com.example.escale;

import android.content.Context;
import android.content.SharedPreferences;

import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MediaType;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class ApiClient {

    // ⚠️ Remplace par ton IP locale (ipconfig) ou 10.0.2.2 si émulateur
    private static final String BASE_URL = "http://192.168.0.113/PPE3/api/index.php/";
    private static final String PREFS_NAME = "ppe3_prefs";
    private static final String KEY_TOKEN = "token";

    private final OkHttpClient client = new OkHttpClient();
    private final Context context;

    public ApiClient(Context context) {
        this.context = context;
    }

    // ── Sauvegarde / lecture du token ──────────────────────────────────────

    public void sauvegarderToken(String token) {
        context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE)
                .edit().putString(KEY_TOKEN, token).apply();
    }

    public String getToken() {
        return context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE)
                .getString(KEY_TOKEN, "");
    }

    public void supprimerToken() {
        context.getSharedPreferences(PREFS_NAME, Context.MODE_PRIVATE)
                .edit().remove(KEY_TOKEN).apply();
    }

    // ── Interface callback générique ───────────────────────────────────────

    public interface ApiCallback {
        void onSucces(JSONObject reponse);
        void onErreur(String message);
    }

    // ── CONNEXION ──────────────────────────────────────────────────────────

    public void connecter(String login, String mdp, ApiCallback callback) {
        try {
            JSONObject bodyJson = new JSONObject();
            bodyJson.put("id", login);
            bodyJson.put("mdp", mdp);

            RequestBody body = RequestBody.create(
                    bodyJson.toString(),
                    MediaType.get("application/json")
            );

            Request request = new Request.Builder()
                    .url(BASE_URL + "connecteArmateur")
                    .post(body)
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    callback.onErreur("Impossible de joindre le serveur");
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    try {
                        JSONObject json = new JSONObject(response.body().string());
                        if (json.getBoolean("succes")) {
                            sauvegarderToken(json.getString("token"));
                            callback.onSucces(json);
                        } else {
                            callback.onErreur(json.getString("message"));
                        }
                    } catch (Exception e) {
                        callback.onErreur("Erreur de lecture de la réponse");
                    }
                }
            });
        } catch (Exception e) {
            callback.onErreur("Erreur de construction de la requête");
        }
    }

    // ── DÉCONNEXION ────────────────────────────────────────────────────────

    public void deconnecter() {
        supprimerToken();
        // Pas besoin d'appeler l'API, le token est juste supprimé localement
    }

    // ── VOIR LES NAVIRES ───────────────────────────────────────────────────

    public void voirNavires(ApiCallback callback) {
        RequestBody body = RequestBody.create("{}", MediaType.get("application/json"));

        Request request = new Request.Builder()
                .url(BASE_URL + "voirNaviresArmateur")
                .addHeader("X-Token", getToken())
                .post(body)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                callback.onErreur("Impossible de joindre le serveur");
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                try {
                    JSONObject json = new JSONObject(response.body().string());
                    if (json.getBoolean("succes")) {
                        callback.onSucces(json);
                    } else {
                        callback.onErreur(json.getString("message"));
                    }
                } catch (Exception e) {
                    callback.onErreur("Erreur de lecture de la réponse");
                }
            }
        });
    }

    // ── DEMANDE D'ESCALE ───────────────────────────────────────────────────

    public void demanderEscale(int idNavire, String dateArrive, String dateDepart, ApiCallback callback) {
        try {
            JSONObject bodyJson = new JSONObject();
            bodyJson.put("id_navire", idNavire);
            bodyJson.put("date_arrive", dateArrive);
            bodyJson.put("date_depart", dateDepart);

            RequestBody body = RequestBody.create(
                    bodyJson.toString(),
                    MediaType.get("application/json")
            );

            Request request = new Request.Builder()
                    .url(BASE_URL + "demandeEscale")
                    .addHeader("X-Token", getToken())
                    .post(body)
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    callback.onErreur("Impossible de joindre le serveur");
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    try {
                        JSONObject json = new JSONObject(response.body().string());
                        if (json.getBoolean("succes")) {
                            callback.onSucces(json);
                        } else {
                            callback.onErreur(json.getString("message"));
                        }
                    } catch (Exception e) {
                        callback.onErreur("Erreur de lecture de la réponse");
                    }
                }
            });

        } catch (Exception e) {
            callback.onErreur("Erreur de construction de la requête");
        }
    }
}
