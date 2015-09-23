package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.Request;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.validator.EmailValidator;
import com.edvaldotsi.fastfood.validator.EmptyValidator;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.rengwuxian.materialedittext.validation.RegexpValidator;

import org.json.JSONException;

public class ClienteActivity extends ToolbarActivity implements Request {

    private MaterialEditText edtNome, edtEmail, edtSenha;

    private Cliente cliente;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_cliente);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Minhas informações");

        edtNome = (MaterialEditText) findViewById(R.id.edt_nome);
        //edtNome.setText(cliente.getNome());
        edtNome.addValidator(new EmptyValidator("Preencha o campo nome"));
        edtNome.setValidateOnFocusLost(true);

        edtEmail = (MaterialEditText) findViewById(R.id.edt_email);
        //edtEmail.setText(cliente.getEmail());
        edtEmail.addValidator(new EmailValidator("Endereço de e-mail inválido"));
        edtEmail.setValidateOnFocusLost(true);

        edtSenha = (MaterialEditText) findViewById(R.id.edt_senha);
        edtSenha.addValidator(new RegexpValidator("Esta senha é muito fraca (min 8)", "\\w{8,}"));
        edtSenha.setValidateOnFocusLost(true);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_default, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;
            case R.id.act_salvar:
                salvarCliente();
                break;
        }
        return super.onOptionsItemSelected(item);
    }

    private void salvarCliente() {
        if (!edtNome.validate() || !edtEmail.validate() || !edtSenha.validate())
            return;

        PostData data = new PostData();
        data.put("nome", edtNome.getText().toString());
        data.put("email", edtEmail.getText().toString());
        data.put("senha", edtSenha.getText().toString());

        ServerRequest request = new ServerRequest(this, this);
        request.setPostData(data);
        request.execute(getResources().getString(R.string.server_host) + "clientes/cadastrar");
    }

    @Override
    public void onRequestSuccess(ServerResponse response) {
        try {
            showMessage(response.getMessage());
            finish();
        } catch (JSONException e) {}
    }

    @Override
    public void onRequestError(Exception ex) {

    }
}
