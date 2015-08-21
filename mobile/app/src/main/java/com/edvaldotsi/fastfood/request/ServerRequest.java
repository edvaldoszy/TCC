package com.edvaldotsi.fastfood.request;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.CookieHandler;
import java.net.CookieManager;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by Edvaldo on 20/08/2015.
 */
public class ServerRequest extends AsyncTask<String, String, String> {

    private Context context;
    private RequestInterface task;
    private ProgressDialog dialog;

    private String cookie;

    public ServerRequest(Context context, RequestInterface requestTask) {
        this.context = context;
        this.task = requestTask;

        CookieHandler.setDefault(new CookieManager());
    }

    @Override
    protected void onPreExecute() { // Execute in main Thread
        dialog = new ProgressDialog(context);
        dialog.setCancelable(false);
        dialog.setMessage("Carregando...");
        dialog.show();
    }

    @Override
    protected String doInBackground(String... params) { // Execute in other Thread
        try {
            URL url = new URL(params[0]);
            HttpURLConnection con = (HttpURLConnection) url.openConnection();
            con.setDoOutput(true);
            con.setRequestMethod("POST");
            BufferedReader reader = new BufferedReader(new InputStreamReader(con.getInputStream()));
            return reader.readLine();
        } catch (IOException ex) {
            dialog.setMessage(ex.getMessage());
            dialog.dismiss();
        }
        return null;
    }

    @Override
    protected void onProgressUpdate(String... values) {
        super.onProgressUpdate(values);
    }

    @Override
    protected void onPostExecute(String json) { // Execute after other Thread
        task.afterRequest(json);
        dialog.dismiss();
    }
}
