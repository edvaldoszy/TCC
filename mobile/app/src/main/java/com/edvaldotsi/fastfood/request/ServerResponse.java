package com.edvaldotsi.fastfood.request;

import com.edvaldotsi.fastfood.model.Produto;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Edvaldo on 23/08/2015.
 */
public class ServerResponse implements Serializable {

    private JSONObject json;

    public ServerResponse(String s) {
        try {
            this.json = new JSONObject(s);
        } catch (JSONException ex) {}
    }

    public String getStatus() throws JSONException {
        return json.getString("status");
    }

    public JSONObject getJson() {
        return json;
    }

    public List<Produto> getProdutos() throws JSONException {
        List<Produto> l = new ArrayList<>();

        if (json.getString("status").equals("OK")) {
            JSONArray data = json.getJSONArray("data");
            for (int n = 0; n < data.length(); n++) {
                JSONObject i = data.getJSONObject(n);

                Produto p = new Produto();
                p.setCodigo(i.getInt("codigo"));
                p.setNome(i.getString("nome"));
                p.setValor(i.getDouble("valor"));
                l.add(p);
            }
        }
        return l;
    }

    @Override
    public String toString() {
        return json.toString();
    }
}
