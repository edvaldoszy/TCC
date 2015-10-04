package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.request.Request;
import com.edvaldotsi.fastfood.request.ServerResponse;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class LoginActivity extends ToolbarActivity {

    private EditText edtEmail;
    private EditText edtSenha;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_login);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle(getString(R.string.title_activity_login));

        edtEmail = (EditText) findViewById(R.id.edtEmail);
        edtSenha = (EditText) findViewById(R.id.edtSenha);
    }

    public void btnLoginAction(View v) {
        startActivity(new Intent(this, MainActivity.class));
        /*
        if (edtEmail.getText().length() < 1 || edtSenha.getText().length() < 1) {
            Toast.makeText(this, "Preencha os dois campos", Toast.LENGTH_SHORT).show();
            return;
        }

        ServerRequest request = new ServerRequest(this, this);
        request.addData("email", edtEmail.getText().toString());
        request.addData("senha", edtSenha.getText().toString());
        request.execute(getResources().getString(R.string.server_host) + "/login/index/mobile");
        */
    }

    @Override
    public void onResponseSuccess(String message, ServerResponse response) {
        /*
        try {
            JSONObject json = response.getJson();
            String status = json.getString("status");
            if (status.equals("d")) {
                JSONObject data = json.getJSONObject("data");
                Cliente u = new Cliente();
                u.setCodigo(data.getInt("codigo"));
                u.setNome(data.getString("nome"));
                u.setEmail(data.getString("email"));
                u.setAdmin(Boolean.parseBoolean(data.getString("admin")));

                Intent i = new Intent(this, MainActivity.class);
                i.putExtra("usuario", u);
                startActivity(i);
            } else {
                Toast.makeText(this, json.getString("message"), Toast.LENGTH_SHORT).show();
            }
        } catch (JSONException ex) {
            Toast.makeText(this, ex.getMessage(), Toast.LENGTH_LONG).show();
        }
        */
    }
}
