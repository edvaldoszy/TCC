package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Contato;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.validator.PhoneValidator;
import com.rengwuxian.materialedittext.MaterialEditText;

import br.com.jansenfelipe.androidmask.MaskEditTextChangedListener;

public class ContatoActivity extends ToolbarActivity {

    private Contato contato;

    private MaterialEditText edtTelefone;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_contato);
        super.onCreate(savedInstanceState);

        edtTelefone = (MaterialEditText) findViewById(R.id.edt_telefone);
        edtTelefone.addTextChangedListener(new MaskEditTextChangedListener("(##)####-####", edtTelefone));
        edtTelefone.addValidator(new PhoneValidator("Telefone inválido"));
        edtTelefone.setValidateOnFocusLost(true);

        try {
            contato = (Contato) getIntent().getSerializableExtra("contato");
            atualizarCampos();
            getToolbar().setTitle("Alterar telefone");
        } catch (NullPointerException ex) {
            getToolbar().setTitle("Adicionar telefone");
            ex.printStackTrace();
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

    private void atualizarCampos() {
        edtTelefone.setText(contato.getTelefone());
    }

    private void salvar() {
        if (!edtTelefone.validate())
            return;

        PostData data = new PostData();
        data.put("telefone", edtTelefone.getText().toString());

        ServerRequest request = new ServerRequest(this, this);
        if (contato == null) {
            String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/contatos/0?acao=novo";
            request.send(path, data);
        } else {
            String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/contatos/" + contato.getCodigo();
            request.send(path, data);
        }
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        showMessage("Dados atualizados com sucesso");
        ContaActivity.updated = false;
        finish();
    }
}
