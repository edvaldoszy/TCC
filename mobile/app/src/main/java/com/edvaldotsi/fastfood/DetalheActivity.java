package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ListView;

import com.edvaldotsi.fastfood.adapter.DetalheAdapter;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.Request;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

public class DetalheActivity extends ToolbarActivity {

    private Produto produto;

    private ListView lvItem;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_detalhe);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle(getString(R.string.title_activity_detalhe));

        try {
            produto = (Produto) getIntent().getSerializableExtra("produto");
            getToolbar().setTitle(produto.getNome());

            PostData data = new PostData();
            data.put("produto", String.valueOf(produto.getCodigo()));

            ServerRequest request = new ServerRequest(this, this);
            request.setPostData(data);
            request.execute(getResources().getString(R.string.server_host) + "produtos/itens");

        } catch (NullPointerException ex) {
            showMessage("Erro ao carregar informações do produto");
            finish();
        }

        lvItem = (ListView) findViewById(R.id.lvItem);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_detalhe, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;
        }

        return true;
    }

    @Override
    public void onResponseSuccess(String message, ServerResponse response) {
        try {
            lvItem.setAdapter(new DetalheAdapter(this, response.getItens(produto)));
        } catch (Exception ex) {
            showMessage(ex.getMessage());
            ex.printStackTrace();
        }
    }
}
