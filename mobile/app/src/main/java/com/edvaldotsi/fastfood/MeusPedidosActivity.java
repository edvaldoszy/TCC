package com.edvaldotsi.fastfood;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.widget.RecyclerView;
import android.view.ContextMenu;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import com.edvaldotsi.fastfood.adapter.MeusPedidosAdapter;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Carrinho;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.ConfirmDialog;

import org.json.JSONException;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class MeusPedidosActivity extends ToolbarActivity {

    private int position;
    private MeusPedidosAdapter adapter;
    private RecyclerView rvMeusPedidos;

    private char situacaoFiltro;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_meus_pedidos);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle("Meus pedidos");

        adapter = new MeusPedidosAdapter(this) {
            @Override
            protected boolean onLongItemClickListener(int adapterPosition, int layoutPosition) {
                position = adapterPosition;
                return false;
            }
        };
        rvMeusPedidos = getRecyclerView(R.id.rv_meus_pedidos);
        rvMeusPedidos.setAdapter(adapter);
        rvMeusPedidos.setOnCreateContextMenuListener(new View.OnCreateContextMenuListener() {
            @Override
            public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
                menu.add(1, 200, 0, "Cancelar pedido");
            }
        });

        filtrarPedidos(Pedido.ABERTO);
    }

    @Override
    public boolean onContextItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case 200:
                excluir(adapter.getItem(position));
                break;
        }
        return super.onContextItemSelected(item);
    }

    private void excluir(final Pedido pedido) {
        ConfirmDialog dialog = new ConfirmDialog(this, "Cancelar pedido", "Deseja realmente cancelar este pedido?") {
            @Override
            public void onPositiveButtonClick(DialogInterface dialog, int which) {
                if (pedido.getSituacao() == Pedido.PRODUCAO || pedido.getSituacao() == Pedido.FECHADO) {
                    showMessage("Este pedido não pode ser cancelado");
                    return;
                }

                ServerRequest request = new ServerRequest(MeusPedidosActivity.this,
                        ServerRequest.METHOD_DELETE, new ServerRequest.RequestListener() {

                    @Override
                    public void onResponseSuccess(ServerResponse response) {
                        if (response.getCode() == 200) {
                            showMessage("Pedido excluído");
                            adapter.getItems().remove(pedido);
                            adapter.notifyDataSetChanged();
                        }
                    }

                    @Override
                    public void onResponseError(ServerResponse response) {
                        if (response.getCode() == 406) {
                            showMessage("Este pedido não pode ser cancelado");
                            return;
                        }
                        MeusPedidosActivity.this.onResponseError(response);
                    }

                    @Override
                    public void onRequestError(ServerResponse response) {
                        MeusPedidosActivity.this.onResponseError(response);
                    }
                });
                request.send("/pedidos/" + pedido.getCodigo());
            }
        };
        dialog.show();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_meus_pedidos, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;

            case R.id.mn_pedidos_abertos:
                filtrarPedidos(Pedido.ABERTO);
                break;

            case R.id.mn_pedidos_fechados:
                filtrarPedidos(Pedido.FECHADO);
                break;
        }
        return super.onOptionsItemSelected(item);
    }

    private void filtrarPedidos(char situacao) {
        if (situacaoFiltro == situacao)
            return;

        if (situacao == Pedido.FECHADO) {
            getToolbar().setSubtitle("Pedidos fechados");
        } else {
            getToolbar().setSubtitle("Pedido em andamento");
        }

        situacaoFiltro = situacao;
        ServerRequest request = new ServerRequest(this, this);

        if (situacao == Pedido.FECHADO)
            request.addParam("situacao", String.valueOf(situacao));

        request.send("/pedidos/cliente/" + ContaDAO.getCliente().getCodigo());
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        if (response.getCode() != 200) {
            showMessage("Erro ao obter lista de pedidos, tente novamente mais tarde");
            return;
        }

        try {
            String str = response.getJSONArray("pedidos").toString();
            Pedido[] arr = response.decode(str, Pedido[].class);
            List<Pedido> pedidos = new ArrayList<>(Arrays.asList(arr));
            adapter.setItems(pedidos);
            adapter.notifyDataSetChanged();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
