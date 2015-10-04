package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.rengwuxian.materialedittext.MaterialEditText;
import com.rengwuxian.materialedittext.validation.RegexpValidator;

public class EnderecoActivity extends ToolbarActivity {

    private MaterialEditText edtLogradouro;
    private MaterialEditText edtNumero;
    private MaterialEditText edtBairro;
    private String lat, lng;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_endereco);
        super.onCreate(savedInstanceState);

        edtLogradouro = (MaterialEditText) findViewById(R.id.edt_logradouro);
        edtLogradouro.addValidator(new RegexpValidator("Informe uma avenida, rua ou logradouro", "\\w+"));

        edtNumero = (MaterialEditText) findViewById(R.id.edt_numero);
        edtNumero.addValidator(new RegexpValidator("Informe o número", "\\w+"));

        edtBairro = (MaterialEditText) findViewById(R.id.edt_bairro);
        edtBairro.addValidator(new RegexpValidator("Informe um bairro", "\\w+"));
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
                salvarEndereco();
                break;
        }
        return super.onOptionsItemSelected(item);
    }

    private void salvarEndereco() {
        if (!edtLogradouro.validate() || !edtNumero.validate() || !edtBairro.validate())
            return;

        PostData data = new PostData();
        data.put("logradouro", edtLogradouro.getText().toString());
        data.put("numero", edtNumero.getText().toString());
        data.put("bairro", edtBairro.getText().toString());

        ServerRequest request = new ServerRequest(this, this);
        request.send("/cliente/endereco/cadastrar", data);
    }

    @Override
    public void onResponseSuccess(String message, ServerResponse response) {
        showMessage("Endereço cadastrado com sucesso");
    }
}
