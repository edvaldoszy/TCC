package com.edvaldotsi.fastfood.request;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.CookieHandler;
import java.net.CookieManager;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.HashMap;

/**
 * Created by Edvaldo on 20/08/2015.
 */
public class ServerRequest extends AsyncTask<String, String, String> {

    private Context context;
    private RequestInterface task;
    private ProgressDialog dialog;

    private static String cookie;

    private HttpURLConnection con;

    private HashMap<String, String> data;

    public ServerRequest(Context context, RequestInterface task) {
        this.context = context;
        this.task = task;

        this.data = new HashMap<>();

        CookieHandler.setDefault(new CookieManager());
    }

    public void addData(String key, String value) {
        data.put(key, value);
    }

    private String getPostData()
    {
        StringBuilder out = new StringBuilder();
        for (String name : data.keySet()) {
            if (out.length() > 0)
                out.append("&");

            out.append(name);
            out.append("=");
            out.append(data.get(name));
        }

        return out.toString();
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
            con = (HttpURLConnection) url.openConnection();
            con.setDoOutput(true);
            con.setRequestMethod("POST");

            if (data.size() > 0) {
                DataOutputStream data = new DataOutputStream(con.getOutputStream());
                data.writeBytes(getPostData());
            }

            if (cookie != null) {
                con.addRequestProperty("Cookie", cookie);
            } else {
                String session = con.getHeaderField("Set-Cookie");
                if (session != null)
                    cookie = session;
            }

            BufferedReader reader = new BufferedReader(new InputStreamReader(con.getInputStream()));
            return reader.readLine();
        } catch (IOException ex) {
            ex.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onProgressUpdate(String... values) {
        super.onProgressUpdate(values);
    }

    @Override
    protected void onPostExecute(String response) { // Execute after other Thread
        task.afterRequest(new ServerResponse(response));
        dialog.dismiss();
        con = null;
    }
}
