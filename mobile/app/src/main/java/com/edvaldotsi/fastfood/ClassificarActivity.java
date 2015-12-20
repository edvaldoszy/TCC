package com.edvaldotsi.fastfood;

import android.app.NotificationManager;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageButton;
import android.widget.Toast;

import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.rengwuxian.materialedittext.MaterialEditText;

import org.json.JSONException;

import java.util.ArrayList;
import java.util.List;

public class ClassificarActivity extends ToolbarActivity {

    private Produto produto;
    private int nota;

    private MaterialEditText edObs;
    private List<ImageButton> notas;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_classificar);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Classificar produto");
        getToolbar().setSubtitle("Ajude-nos a melhorar");

        NotificationManager manager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);
        manager.cancel(R.integer.NOTIFICATION_ID);

        edObs = (MaterialEditText) findViewById(R.id.ed_obs);

        notas = new ArrayList<>();
        notas.add((ImageButton) findViewById(R.id.nota_1));
        notas.add((ImageButton) findViewById(R.id.nota_2));
        notas.add((ImageButton) findViewById(R.id.nota_3));
        notas.add((ImageButton) findViewById(R.id.nota_4));
        notas.add((ImageButton) findViewById(R.id.nota_5));

        produto = (Produto) getIntent().getSerializableExtra("produto");
        getToolbar().setTitle("Classificar " + produto.getNome());

        //ServerRequest request = new ServerRequest(this, this);
        //request.send("/produtos/3/detalhes");
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

        ServerRequest request = new ServerRequest(this, ServerRequest.METHOD_POST, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {
                Toast.makeText(ClassificarActivity.this, "Obrigato :)", Toast.LENGTH_LONG).show();
                finish();
            }

            @Override
            public void onResponseError(ServerResponse response) {
                Toast.makeText(ClassificarActivity.this, "Você já votou neste produto", Toast.LENGTH_SHORT).show();
                finish();
            }

            @Override
            public void onRequestError(ServerResponse response) {
                Toast.makeText(ClassificarActivity.this, "Você já votou neste produto", Toast.LENGTH_SHORT).show();
                finish();
            }
        });

        PostData data = new PostData();
        if (!"".equals(edObs.getText().toString()))
            data.put("obs", edObs.getText().toString());

        String url = "/produtos/votar/" + ProdutosPedidoActivity.clienteCodigo + "/" + produto.getCodigo() + "/" + nota;
        request.send(url, data);
    }


    private void nota(int v) {
        nota = v;
        for (int n = 0; n < notas.size(); n++) {
            if (n < v) {
                notas.get(n).setImageResource(R.drawable.ic_star_on);
            } else {
                notas.get(n).setImageResource(R.drawable.ic_star_off);
            }
        }
    }

    public void nota1(View view) {
        nota(1);
    }

    public void nota2(View view) {
        nota(2);
    }

    public void nota3(View view) {
        nota(3);
    }

    public void nota4(View view) {
        nota(4);
    }

    public void nota5(View view) {
        nota(5);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        try {
            String json = response.getJSONObject("produto").toString();
            produto = response.decode(json, Produto.class);

            getToolbar().setTitle("Classificar " + produto.getNome());
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
