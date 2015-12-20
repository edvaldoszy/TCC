package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.adapter.ProdutoPedidoAdapter;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

import org.json.JSONArray;
import org.json.JSONException;

public class ProdutosPedidoActivity extends ToolbarActivity {

    private ProdutoPedidoAdapter adapter;
    private RecyclerView rvProdutos;

    public static int clienteCodigo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_produtos_pedido);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Avaliar produto");

        adapter = new ProdutoPedidoAdapter(this) {
            @Override
            protected void onItemClickListener(int position, int layoutPosition) {
                Intent intent = new Intent(ProdutosPedidoActivity.this, ClassificarActivity.class);
                intent.putExtra("produto", adapter.getItem(position));
                startActivity(intent);
            }
        };
        rvProdutos = getRecyclerView(R.id.rv_produtos);
        rvProdutos.setAdapter(adapter);

        int codigo = getIntent().getIntExtra("pedido_codigo", 0);
        if (codigo != 0) {
            ServerRequest request = new ServerRequest(this, this);
            request.send("/pedidos/" + codigo + "/produtosclassificacao");
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        try {
            clienteCodigo = response.getJSONObject("cliente").getInt("codigo");

            String jsonProdutos = response.getJSONArray("produtos").toString();
            Produto[] produtos = response.decode(jsonProdutos, Produto[].class);

            adapter.setItems(produtos);
            adapter.notifyDataSetChanged();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
