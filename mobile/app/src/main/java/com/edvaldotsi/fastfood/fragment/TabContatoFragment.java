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
import android.widget.AdapterView;
import android.widget.Toast;

import com.edvaldotsi.fastfood.ContatoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.adapter.ContatoAdapter;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Contato;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.ConfirmDialog;

import java.util.List;

public class TabContatoFragment extends Fragment {

    private static final int FRAGMENT_GROUPID = 40;
    private static final int MENU_ALTERAR = 1;
    private static final int MENU_EXCLUIR = 2;

    private Activity activity;
    private RecyclerView rvContatos;

    private List<Contato> contatos;
    private int position; // POG: armazena a posição do item clicado na lista para editar ou excluir quando clica no menu de contexto

    public static TabContatoFragment newInstance() {
        return new TabContatoFragment();
    }

    public TabContatoFragment() {
        // Required empty public constructor
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
                startActivity(new Intent(activity, ContatoActivity.class));
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_tab_contato, container, false);

        rvContatos = (RecyclerView) view.findViewById(R.id.rv_contatos);
        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rvContatos.setLayoutManager(llm);
        registerForContextMenu(rvContatos);

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
                    alterar(contatos.get(position));
                    break;

                case MENU_EXCLUIR:
                    excluir(contatos.get(position));
                    break;
            }
        }
        return super.onContextItemSelected(item);
    }

    private void alterar(Contato contato) {
        Intent intent = new Intent(activity, ContatoActivity.class);
        intent.putExtra("contato", contato);
        startActivity(intent);
    }

    private void excluir(final Contato contato) {
        ConfirmDialog dialog = new ConfirmDialog(activity, "Contato", "Deseja excluir este contato?") {
            @Override
            public void onPositiveButtonClick(DialogInterface dialog, int which) {
                ServerRequest request = new ServerRequest(activity, new ServerRequest.RequestListener() {
                    @Override
                    public void onResponseSuccess(ServerResponse response) {
                        ContaDAO.getContatos().remove(contato);
                        rvContatos.getAdapter().notifyDataSetChanged();
                    }

                    @Override
                    public void onResponseError(ServerResponse response) {}

                    @Override
                    public void onRequestError(ServerResponse response) {}
                }, ServerRequest.METHOD_DELET);
                String path = "/clientes/" + ContaDAO.getCliente().getCodigo() + "/contatos/" + contato.getCodigo();
                request.send(path);
            }
        };
        dialog.show();
    }

    private void update() {
        contatos = ContaDAO.getConta().getContatos();
        ContatoAdapter adapter = new ContatoAdapter(activity, contatos) {
            @Override
            protected boolean onLongItemClickListener(int adapterPosition, int layoutPosition) {
                position = adapterPosition;
                return false;
            }
        };
        rvContatos.setAdapter(adapter);
    }
}
