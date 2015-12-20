package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ArrayAdapter;
import android.widget.Spinner;

import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Cidade;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.model.Contato;
import com.edvaldotsi.fastfood.model.Endereco;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.validator.EmailValidator;
import com.edvaldotsi.fastfood.validator.EmptyValidator;
import com.edvaldotsi.fastfood.validator.PhoneValidator;
import com.rengwuxian.materialedittext.MaterialEditText;

import org.json.JSONException;

import java.util.ArrayList;
import java.util.List;

import br.com.jansenfelipe.androidmask.MaskEditTextChangedListener;

public class CadastroClienteActivity extends ToolbarActivity {

    private MaterialEditText edNome;
    private MaterialEditText edEmail;
    private MaterialEditText edSenha;

    private MaterialEditText edTelefone;

    private MaterialEditText edLogradouro;
    private MaterialEditText edNumero;
    private MaterialEditText edBairro;
    private Spinner spCidade;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_cadastro_cliente);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Criar nova conta");

        edNome = (MaterialEditText) findViewById(R.id.ed_nome);
        edNome.addValidator(new EmptyValidator("Preencha o campo nome"));
        edNome.setValidateOnFocusLost(true);

        edEmail = (MaterialEditText) findViewById(R.id.ed_email);
        edEmail.addValidator(new EmailValidator("Endereço de e-mail inválido"));
        edEmail.setValidateOnFocusLost(true);
        String email = getIntent().getStringExtra("email");
        if (email != null)
            edEmail.setText(email);

        edSenha = (MaterialEditText) findViewById(R.id.ed_senha);
        edSenha.addValidator(new EmptyValidator("Preencha o campo senha"));
        edSenha.setValidateOnFocusLost(true);
        String senha = getIntent().getStringExtra("senha");
        if (senha != null)
            edSenha.setText(senha);

        edTelefone = (MaterialEditText) findViewById(R.id.ed_telefone);
        edTelefone.addTextChangedListener(new MaskEditTextChangedListener("(##)####-####", edTelefone));
        edTelefone.addValidator(new PhoneValidator("Número de telefone inválido"));
        edTelefone.setValidateOnFocusLost(true);

        edLogradouro = (MaterialEditText) findViewById(R.id.ed_logradouro);
        edLogradouro.addValidator(new EmptyValidator("Preencha o campo logradouro"));
        edLogradouro.setValidateOnFocusLost(true);

        edNumero = (MaterialEditText) findViewById(R.id.ed_numero);
        edNumero.addValidator(new EmptyValidator("Preencha o número do endereço"));
        edNumero.setValidateOnFocusLost(true);

        edBairro = (MaterialEditText) findViewById(R.id.ed_bairro);
        edBairro.addValidator(new EmptyValidator("Informe o bairro"));
        edBairro.setValidateOnFocusLost(true);

        spCidade = (Spinner) findViewById(R.id.sp_cidade);
        ServerRequest request = new ServerRequest(this, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {
                try {
                    Cidade[] cidades = gson.fromJson(response.getJSONArray("cidades").toString(), Cidade[].class);
                    ArrayAdapter adapter = new ArrayAdapter<>(CadastroClienteActivity.this, android.R.layout.simple_list_item_1, cidades);
                    spCidade.setAdapter(adapter);
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onResponseError(ServerResponse response) {
                CadastroClienteActivity.this.onResponseSuccess(response);
            }
            @Override
            public void onRequestError(ServerResponse response) {
                CadastroClienteActivity.this.onRequestError(response);
            }
        });
        request.send("/cidades");
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

        if (!edNome.validate() || !edEmail.validate() || !edSenha.validate() || !edTelefone.validate())
            return;

        if (!edLogradouro.validate() || !edNumero.validate() || !edBairro.validate())
            return;

        JSONCliente json = new JSONCliente();

        Cliente cliente = new Cliente();
        cliente.setNome(edNome.getText().toString());
        cliente.setEmail(edEmail.getText().toString());
        cliente.setSenha(ContaDAO.md5(edSenha.getText().toString()));
        json.cliente = cliente;

        json.contatos.add(new Contato(edTelefone.getText().toString()));

        Endereco endereco = new Endereco();
        endereco.setLogradouro(edLogradouro.getText().toString());
        endereco.setNumero(edNumero.getText().toString());
        endereco.setBairro(edBairro.getText().toString());
        endereco.setCidade((Cidade) spCidade.getSelectedItem());
        json.enderecos.add(endereco);

        PostData data = new PostData();
        data.put("data", gson.toJson(json));

        ServerRequest request = new ServerRequest(this, this, ServerRequest.METHOD_POST);
        request.send("/clientes/novo", data);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {

        if (response.getCode() != 200) {
            showMessage(response.getMessage());
            return;
        }

        Intent intent = new Intent();
        intent.putExtra("email", edEmail.getText().toString());
        intent.putExtra("senha", edSenha.getText().toString());

        setResult(RESULT_OK, intent);
        showMessage("Cliente cadastrado com sucesso");
        finish();
    }

    private class JSONCliente {

        public Cliente cliente;
        public List<Contato> contatos;
        public List<Endereco> enderecos;

        public JSONCliente() {
            contatos = new ArrayList<>();
            this.enderecos = new ArrayList<>();
        }
    }
}
