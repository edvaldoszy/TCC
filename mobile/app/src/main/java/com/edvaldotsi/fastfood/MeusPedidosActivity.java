package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

public class MeusPedidosActivity extends ToolbarActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_meus_pedidos);
        super.onCreate(savedInstanceState);

        ServerRequest request = new ServerRequest(this, this);
        request.send("/meuspedidos/" + ContaDAO.getCliente().getCodigo());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_meus_pedidos, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {

    }
}
