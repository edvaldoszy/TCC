package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.dao.ClienteDAO;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.validator.EmailValidator;
import com.edvaldotsi.fastfood.validator.EmptyValidator;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.rengwuxian.materialedittext.validation.RegexpValidator;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class ClienteActivity extends ToolbarActivity {

    private MaterialEditText edtNome, edtEmail, edtSenha;
    private Cliente cliente;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_cliente);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Minhas informações");

        edtNome = (MaterialEditText) findViewById(R.id.edt_nome);
        edtNome.addValidator(new EmptyValidator("Informe seu nome completo"));
        edtNome.setValidateOnFocusLost(true);

        edtEmail = (MaterialEditText) findViewById(R.id.edt_email);
        edtEmail.addValidator(new EmailValidator("Endereço de e-mail inválido"));
        edtEmail.setValidateOnFocusLost(true);

        edtSenha = (MaterialEditText) findViewById(R.id.edt_senha);

        try {
            cliente = ContaDAO.getCliente();
            edtNome.setText(cliente.getNome());
            edtEmail.setText(cliente.getEmail());
        } catch (NullPointerException ex) {
            showMessage("Algo deu errado! Tente novamente mais tarde :(");
            ex.printStackTrace();
            finish();
        }
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
                salvar();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    private void salvar() {
        if (!edtNome.validate() || !edtEmail.validate())
            return;

        PostData data = new PostData();
        try {
            data.put("nome", URLEncoder.encode(edtNome.getText().toString(), "UTF-8"));
            data.put("email", edtEmail.getText().toString());

            if (!"".equals(edtSenha.getText().toString()))
                data.put("senha", ContaDAO.md5(edtSenha.getText().toString()));

            ServerRequest request = new ServerRequest(this, this, ServerRequest.METHOD_POST);
            request.send("/clientes/" + cliente.getCodigo(), data);
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            showMessage("Falha na codificação dos caracteres");
        }
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        showMessage("Informações salvas com sucesso");
        ContaActivity.updated = false;
        finish();
    }
}
