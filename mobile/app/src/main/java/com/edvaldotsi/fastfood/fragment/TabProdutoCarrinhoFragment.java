package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.StaggeredGridLayoutManager;
import android.view.ContextMenu;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;

import com.edvaldotsi.fastfood.PedidoActivity;
import com.edvaldotsi.fastfood.ProdutoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.adapter.DetalhesAdapter;
import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.util.ConfirmDialog;

public class TabProdutoCarrinhoFragment extends Fragment implements PedidoActivity.ValidacaoListener {

    private int position;

    private static final int FRAGMENT_GROUPID = 50;
    private static final int MENU_ALTERAR = 1;
    private static final int MENU_EXCLUIR = 2;

    private Activity activity;
    private PedidoActivity listener;

    private RecyclerView rvDetalhes;

    public static TabProdutoCarrinhoFragment newInstance() {
        return new TabProdutoCarrinhoFragment();
    }

    public TabProdutoCarrinhoFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_tab_produto_carrinho, container, false);

        rvDetalhes = (RecyclerView) v.findViewById(R.id.rv_detalhes);
        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rvDetalhes.setLayoutManager(llm);
        registerForContextMenu(rvDetalhes);

        update();
        listener.getToolbar().setSubtitle("Produtos");
        return v;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
        this.listener = (PedidoActivity) activity;
    }

    @Override
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);
        menu.add(FRAGMENT_GROUPID, MENU_ALTERAR, Menu.NONE, "Alterar");
        menu.add(FRAGMENT_GROUPID, MENU_EXCLUIR, Menu.NONE, "Excluir");
        menu.add(FRAGMENT_GROUPID, 0, Menu.NONE, "Cancelar");
    }

    @Override
    public boolean onContextItemSelected(MenuItem item) {

        if (item.getGroupId() == FRAGMENT_GROUPID) {

            switch (item.getItemId()) {
                case MENU_ALTERAR:
                    alterarProduto();
                    break;

                case MENU_EXCLUIR:
                    excluirProduto();
                    break;
            }
        }
        return super.onContextItemSelected(item);
    }

    @Override
    public void setUserVisibleHint(boolean isVisibleToUser) {
        super.setUserVisibleHint(isVisibleToUser);
        if (isVisibleToUser) {
            listener.getToolbar().setSubtitle("Produtos");
        }
    }

    private void alterarProduto() {
        Intent intent = new Intent(activity, ProdutoActivity.class);
        intent.putExtra("detalhes", PedidoActivity.carrinho.getDetalhes().get(position));
        startActivityForResult(intent, 10);
    }

    private void excluirProduto() {
        ConfirmDialog dialog = new ConfirmDialog(activity, "Produto", "Deseja excluir este produto do carrinho?") {
            @Override
            public void onPositiveButtonClick(DialogInterface dialog, int which) {
                PedidoActivity.carrinho.getDetalhes().remove(position);
                rvDetalhes.getAdapter().notifyDataSetChanged();
                listener.update();
            }
        };
        dialog.show();
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == 10) {
            try {
                Detalhes d = (Detalhes) data.getSerializableExtra("detalhes");
                PedidoActivity.carrinho.getDetalhes().set(position, d);
                rvDetalhes.getAdapter().notifyDataSetChanged();
                listener.update();
                listener.showMessage("Produto alterado");
            } catch (NullPointerException ex) {
                ex.printStackTrace();
            }
        }
    }

    private void update() {
        DetalhesAdapter adapter = new DetalhesAdapter(activity, PedidoActivity.carrinho.getDetalhes()) {
            @Override
            protected boolean onLongItemClickListener(int adapterPosition, int layoutPosition) {
                position = adapterPosition;
                return false;
            }
        };
        rvDetalhes.setAdapter(adapter);
    }

    @Override
    public boolean validar() {
        return rvDetalhes.getAdapter().getItemCount() > 0;
    }
}
