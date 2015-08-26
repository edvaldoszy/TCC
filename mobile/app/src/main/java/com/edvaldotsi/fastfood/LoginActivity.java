package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.edvaldotsi.fastfood.model.Usuario;
import com.edvaldotsi.fastfood.request.RequestInterface;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

import org.json.JSONException;
import org.json.JSONObject;

public class LoginActivity extends AppCompatActivity implements RequestInterface {

    private EditText edtEmail;
    private EditText edtSenha;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        edtEmail = (EditText) findViewById(R.id.edtEmail);
        edtSenha = (EditText) findViewById(R.id.edtSenha);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public void afterRequest(ServerResponse response) {
        try {
            JSONObject json = response.getJson();
            String status = json.getString("status");
            if (status.equals("OK")) {
                JSONObject data = json.getJSONObject("data");
                Usuario u = new Usuario();
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
    }

    public void btnLoginAction(View v) {
        if (edtEmail.getText().length() < 1 || edtSenha.getText().length() < 1) {
            Toast.makeText(this, "Preencha os dois campos", Toast.LENGTH_SHORT).show();
            return;
        }

        ServerRequest request = new ServerRequest(this, this);
        request.addData("email", edtEmail.getText().toString());
        request.addData("senha", edtSenha.getText().toString());
        request.execute("http://192.168.0.16/login/index/mobile");
    }
}
