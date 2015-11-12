package com.edvaldotsi.fastfood.request;

import com.google.gson.Gson;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;

/**
 * Created by Edvaldo on 23/08/2015.
 */
public class ServerResponse {

    public static final String STATUS_OK = "OK";
    public static final String STATUS_ERROR = "ERROR";

    private int code;
    private String message;
    private String output;

    private JSONObject json;
    private Gson gson;

    public ServerResponse (int code, String message){
        gson = new Gson();
        this.code = code;
        this.message = message;
    }

    public ServerResponse(int code, String message, String output) {
        this(code, message);
        this.output = output;
    }

    public <T> T decode(String json, Class<T> type) {
        return gson.fromJson(json, type);
    }

    public int getCode() {
        return code;
    }

    public String getMessage() {
        return message;
    }

    public String getOutput() {
        return output;
    }

    private JSONObject parse() throws JSONException {
        if (json == null)
            json = new JSONObject(output);

        return json;
    }

    public JSONObject getJSONObject(String name) throws JSONException {
        return parse().getJSONObject(name);
    }

    public JSONArray getJSONArray(String name) throws JSONException {
        return parse().getJSONArray(name);
    }
}
