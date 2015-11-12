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
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;

import com.edvaldotsi.fastfood.EnderecoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.adapter.EnderecoAdapter;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Endereco;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.ConfirmDialog;

import java.util.List;

public class TabEnderecoFragment extends Fragment {

    private static final int FRAGMENT_GROUPID = 30;
    private static final int MENU_ALTERAR = 1;
    private static final int MENU_EXCLUIR = 2;


    private Activity activity;
    private RecyclerView rvEnderecos;

    private List<Endereco> enderecos;
    private int position; // POG: armazena a posição do item clicado na lista para editar ou excluir quando clica no menu de contexto

    public TabEnderecoFragment() {
        // Required empty public constructor
    }

    public static TabEnderecoFragment newInstance() {
        return new TabEnderecoFragment();
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        menu.getItem(1).setVisible(false);
        menu.getItem(0).setVisible(true);
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case R.id.mn_novo:
                startActivity(new Intent(activity, EnderecoActivity.class));
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_tab_endereco, container, false);

        rvEnderecos = (RecyclerView) view.findViewById(R.id.rv_enderecos);
        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rvEnderecos.setLayoutManager(llm);
        registerForContextMenu(rvEnderecos);

        update();
        return view;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
    }

    @Override
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);
        menu.add(FRAGMENT_GROUPID, MENU_ALTERAR, Menu.NONE, "Alterar");
        menu.add(FRAGMENT_GROUPID, MENU_EXCLUIR, Menu.NONE, "Excluir");
    }

    @Override
    public boolean onContextItemSelected(MenuItem item) {

        if (item.getGroupId() == FRAGMENT_GROUPID) {

            switch (item.getItemId()) {
                case MENU_ALTERAR:
                    alterar(enderecos.get(position));
                    break;

                case MENU_EXCLUIR:
                    excluir(enderecos.get(position));
                    break;
            }
        }
        return super.onContextItemSelected(item);
    }

    private void alterar(Endereco endereco) {
        Intent intent = new Intent(activity, EnderecoActivity.class);
        intent.putExtra("endereco", endereco);
        startActivity(intent);
    }

    private void excluir(final Endereco endereco) {
        ConfirmDialog dialog = new ConfirmDialog(activity, "Endereço", "Deseja excluir este endereço?") {
            @Override
            public void onPositiveButtonClick(DialogInterface dialog, int which) {
                ServerRequest request = new ServerRequest(activity, new ServerRequest.RequestListener() {
                    @Override
                    public void onResponseSuccess(ServerResponse response) {
                        ContaDAO.getEnderecos().remove(endereco);
                        rvEnderecos.getAdapter().notifyDataSetChanged();
                    }

                    @Override
                    public void onResponseError(ServerResponse response) {}

                    @Override
                    public void onRequestError(ServerResponse response) {}
                }, ServerRequest.METHOD_DELET);
                String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/enderecos/" + endereco.getCodigo();
                request.send(path);
            }
        };
        dialog.show();
    }

    private void update() {
        enderecos = ContaDAO.getConta().getEnderecos();
        EnderecoAdapter adapter = new EnderecoAdapter(activity, enderecos) {
            @Override
            protected boolean onLongItemClickListener(int adapterPosition, int layoutPosition) {
                position = adapterPosition;
                return false;
            }
        };
        rvEnderecos.setAdapter(adapter);
    }
}
