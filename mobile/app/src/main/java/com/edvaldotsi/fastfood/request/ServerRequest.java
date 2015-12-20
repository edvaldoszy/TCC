package com.edvaldotsi.fastfood.request;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;

import com.edvaldotsi.fastfood.R;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by Edvaldo on 20/08/2015.
 */
public class ServerRequest extends AsyncTask<String, String, Void> {

    private static final int CONNECTION_TIMEOUT = 5000;

    private static final int CODE_OK = 200; // Http code for successfully requests
    private static final int CODE_ERR = 510; // Http code for unsuccessfully requests

    public static final String METHOD_GET = "GET";
    public static final String METHOD_POST = "POST";
    public static final String METHOD_PUT = "PUT";
    public static final String METHOD_DELETE = "DELETE";

    private Context context;
    private RequestListener task;
    private ProgressDialog dialog;

    private HttpURLConnection con;
    private String method;
    private static String cookie;
    private PostData param;
    private PostData data;
    private boolean debug = false;

    // Usada para requisições que existe interface do usuário para poder mostrar a janela de carregando
    public boolean hasViews = true;

    private ServerResponse response;

    public ServerRequest(Context context, RequestListener task) {
        this.context = context;
        this.task = task;
        this.method = METHOD_GET;
    }

    public ServerRequest(Context context, String method, RequestListener task) {
        this.context = context;
        this.method = method;
        this.task = task;
    }

    public ServerRequest(Context context, RequestListener task, String method) {
        this.context = context;
        this.task = task;
        this.method = method;
    }

    public void addParam(String key, String value) {
        if (param == null)
            param = new PostData();

        param.put(key, value);
    }

    public void addParam(String key, int value) {
        if (param == null)
            param = new PostData();

        param.put(key, value);
    }

    public void setPostData(PostData data) {
        this.data = data;
    }

    public void send(String path) {
        String host = context.getResources().getString(R.string.api_host);
        execute(host + path);
    }

    public void send(String path, PostData data) {
        setPostData(data);
        send(path);
    }

    public void setDebugMode(boolean estado) {
        debug = estado;
    }

    @Override
    protected void onPreExecute() { // Execute in main Thread
        if (hasViews) {
            dialog = new ProgressDialog(context);
            dialog.setCancelable(false);
            dialog.setMessage("Carregando...");
            dialog.show();
        }
    }

    @Override
    protected Void doInBackground(String... params) { // Execute in another Thread
        try {
            String path = param != null ? (params[0] + (debug ? "?debug=y&" : "?") + param.toString()) : params[0] + (debug ? "?debug=y" : "");
            Log.i("REQUEST", path);

            URL url = new URL(path);
            con = (HttpURLConnection) url.openConnection();
            con.setConnectTimeout(CONNECTION_TIMEOUT);
            //con.setInstanceFollowRedirects(false);
            con.setRequestMethod(method);

            if (cookie != null)
                con.setRequestProperty("Cookie", cookie);

            if (data != null && data.size() > 0) {
                con.setDoOutput(true);
                DataOutputStream output = new DataOutputStream(con.getOutputStream());
                output.writeBytes(data.toString());
                Log.i("POST", data.toString());
            }

            con.connect();

            String c = con.getHeaderField("Set-Cookie");
            if (c != null)
                cookie = c;

            BufferedReader reader;
            int code = con.getResponseCode();
            if (code >= 200 && code < 400) {
                 reader = new BufferedReader(new InputStreamReader(con.getInputStream()));
            } else  {
                reader = new BufferedReader(new InputStreamReader(con.getErrorStream()));
            }

            StringBuilder output = new StringBuilder();
            String line = reader.readLine();
            while (line != null) {
                if (line.isEmpty()) break;

                output.append(line);
                line = reader.readLine();
            }

            response = new ServerResponse(con.getResponseCode(), con.getResponseMessage(), output.toString());
        } catch (IOException ex) {
            response = new ServerResponse(500, ex.getMessage());
            ex.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onPostExecute(Void aVoid) {
        if (hasViews)
            dialog.dismiss();

        int code = response.getCode();
        if (code >= 500) {
            task.onRequestError(response);
        } else if (code >= 400) {
            task.onResponseError(response);
        } else {
            task.onResponseSuccess(response);
            Log.i("OUTPUT", response.getOutput());
        }
    }

    public interface RequestListener {

        void onResponseSuccess(ServerResponse response);

        void onResponseError(ServerResponse response);

        void onRequestError(ServerResponse response);
    }
}
