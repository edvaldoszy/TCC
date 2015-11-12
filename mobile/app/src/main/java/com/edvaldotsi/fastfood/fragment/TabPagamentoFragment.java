package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import com.edvaldotsi.fastfood.PedidoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Pedido;
import com.rengwuxian.materialedittext.MaterialEditText;

public class TabPagamentoFragment extends Fragment implements PedidoActivity.ValidacaoListener {

    private Activity activity;
    private PedidoActivity listener;

    private Button btCartao;
    private Button btDinheiro;
    private MaterialEditText edTroco;

    public static TabPagamentoFragment newInstance() {
        return new TabPagamentoFragment();
    }

    public TabPagamentoFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        menu.getItem(0).setTitle("Finalizar");
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_tab_pagamento, container, false);

        edTroco = (MaterialEditText) v.findViewById(R.id.ed_troco);

        btCartao = (Button) v.findViewById(R.id.bt_cartao);
        btCartao.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                PedidoActivity.carrinho.getPedido().setPagamento(Pedido.PAGAMENTO_CARTAO);
                edTroco.setVisibility(View.GONE);
                listener.update();
            }
        });

        btDinheiro = (Button) v.findViewById(R.id.bt_dinheiro);
        btDinheiro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                PedidoActivity.carrinho.getPedido().setPagamento(Pedido.PAGAMENTO_DINHEIRO);
                edTroco.setVisibility(View.VISIBLE);
                listener.update();
            }
        });

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
            listener.getToolbar().setSubtitle("Forma de pagamento");
        }
    }

    @Override
    public boolean validar() {
        return true;
    }
}
