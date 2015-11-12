package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ArrayAdapter;
import android.widget.Spinner;

import com.edvaldotsi.fastfood.dao.ClienteDAO;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Cidade;
import com.edvaldotsi.fastfood.model.Endereco;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.validator.EmptyValidator;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.rengwuxian.materialedittext.validation.RegexpValidator;

import org.json.JSONException;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Arrays;
import java.util.List;

public class EnderecoActivity extends ToolbarActivity {

    private Endereco endereco;

    private MaterialEditText edLogradouro;
    private MaterialEditText edNumero;
    private MaterialEditText edBairro;
    private Spinner spnCidade;
    private String lat, lng;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_endereco);
        super.onCreate(savedInstanceState);

        edLogradouro = (MaterialEditText) findViewById(R.id.edt_logradouro);
        edLogradouro.addValidator(new EmptyValidator("Informe uma avenida, rua ou logradouro"));

        edNumero = (MaterialEditText) findViewById(R.id.edt_numero);
        edNumero.addValidator(new EmptyValidator("Informe o número do endereço"));

        edBairro = (MaterialEditText) findViewById(R.id.edt_bairro);
        edBairro.addValidator(new EmptyValidator("Informe um bairro do endereço"));

        spnCidade = (Spinner) findViewById(R.id.spnCidade);
        ServerRequest request = new ServerRequest(this, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {

                try {
                    String json = response.getJSONArray("cidades").toString();
                    Cidade[] cidades = gson.fromJson(json, Cidade[].class);
                    ArrayAdapter adapter = new ArrayAdapter<>(EnderecoActivity.this, android.R.layout.simple_list_item_1, cidades);
                    spnCidade.setAdapter(adapter);

                    if (endereco != null) {

                        for (int n = 0; n < spnCidade.getCount(); n++) {
                            Cidade c = (Cidade) spnCidade.getItemAtPosition(n);
                            if (c.equals(endereco.getCidade())) {
                                spnCidade.setSelection(n);
                                break;
                            }
                        }
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onResponseError(ServerResponse response) {}

            @Override
            public void onRequestError(ServerResponse response) {}
        });
        request.send("/cidades");

        try {
            endereco = (Endereco) getIntent().getSerializableExtra("endereco");
            atualizarCampos();
            getToolbar().setTitle("Alterar endereço");
        } catch (NullPointerException ex) {
            getToolbar().setTitle("Adicionar endereço");
            ex.printStackTrace();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_default, menu);
        menu.getItem(0).setVisible(false);
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

    private void atualizarCampos() {
        edLogradouro.setText(endereco.getLogradouro());
        edNumero.setText(endereco.getNumero());
        edBairro.setText(endereco.getBairro());
    }

    private void salvar() {
        if (!edLogradouro.validate() || !edNumero.validate() || !edBairro.validate())
            return;

        PostData data = new PostData();
        try {
            data.put("logradouro", URLEncoder.encode(edLogradouro.getText().toString(), "UTF-8"));
            data.put("numero", edNumero.getText().toString());
            data.put("bairro", URLEncoder.encode(edBairro.getText().toString(), "UTF-8"));
            data.put("cidade", ((Cidade) spnCidade.getSelectedItem()).getCodigo());

            ServerRequest request = new ServerRequest(this, this);
            if (endereco == null) {
                String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/enderecos/0?acao=novo";
                request.send(path, data);
            } else {
                String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/enderecos/" + endereco.getCodigo();
                request.send(path, data);
            }
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            showMessage("Falha na codificação dos caracteres");
        }
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        showMessage("Dados atualizados com sucesso");
        ContaActivity.updated = false;
        finish();
    }
}
