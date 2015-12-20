package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.StaggeredGridLayoutManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.edvaldotsi.fastfood.PedidoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.ToolbarActivity;
import com.edvaldotsi.fastfood.adapter.EnderecoEntregaAdapter;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Endereco;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

import org.json.JSONException;

import java.util.Arrays;
import java.util.List;

public class TabEnderecoEntregaFragment extends Fragment implements PedidoActivity.ValidacaoListener {

    private Activity activity;
    private PedidoActivity listener;

    private EnderecoEntregaAdapter adapter;
    private RecyclerView rvEnderecos;

    public static TabEnderecoEntregaFragment newInstance() {
        return new TabEnderecoEntregaFragment();
    }

    public TabEnderecoEntregaFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        ServerRequest request = new ServerRequest(activity, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {

                try {
                    String json = response.getJSONArray("enderecos").toString();
                    List<Endereco> enderecos = Arrays.asList(response.decode(json, Endereco[].class));
                    adapter = new EnderecoEntregaAdapter(activity, enderecos);
                    update();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

            @Override
            public void onResponseError(ServerResponse response) {
                ((ToolbarActivity) activity).onResponseError(response);
            }

            @Override
            public void onRequestError(ServerResponse response) {
                ((ToolbarActivity) activity).onRequestError(response);
            }
        });
        request.send("/clientes/" + ContaDAO.getCliente().getCodigo() + "/enderecos/0");
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_tab_endereco_entrega, container, false);

        rvEnderecos = (RecyclerView) v.findViewById(R.id.rv_enderecos);
        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rvEnderecos.setLayoutManager(llm);

        update();
        return v;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
        this.listener = (PedidoActivity) activity;
    }

    @Override
    public void setUserVisibleHint(boolean isVisibleToUser) {
        super.setUserVisibleHint(isVisibleToUser);
        if (isVisibleToUser) {
            listener.getToolbar().setSubtitle("Endereço de entrega");
        }
    }

    private void update() {
        rvEnderecos.setAdapter(adapter);
    }

    @Override
    public boolean validar() {
        // Verifica se o endereço selecionado não é nulo e está marcado para entrega
        Endereco endereco = ((EnderecoEntregaAdapter) rvEnderecos.getAdapter()).selecionado();
        if (endereco != null && endereco.isEntrega()) {
            PedidoActivity.carrinho.getPedido().setEndereco(endereco);
            return true;
        }

        return false;
    }
}
