package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CompoundButton;
import android.widget.ToggleButton;

import com.edvaldotsi.fastfood.PedidoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Pedido;
import com.rengwuxian.materialedittext.MaterialEditText;

public class TabPagamentoFragment extends Fragment implements PedidoActivity.ValidacaoListener {

    private Activity activity;
    private PedidoActivity listener;

    private ToggleButton tbCartao;
    private ToggleButton tbDinheiro;
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

        tbCartao = (ToggleButton) v.findViewById(R.id.tb_cartao);
        tbCartao.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

                if (isChecked) {
                    PedidoActivity.carrinho.getPedido().setPagamento(Pedido.PAGAMENTO_CARTAO);
                    tbDinheiro.setChecked(false);
                    edTroco.setVisibility(View.GONE);
                } else {
                    if (PedidoActivity.carrinho.getPedido().getPagamento() == Pedido.PAGAMENTO_CARTAO) {
                        PedidoActivity.carrinho.getPedido().setPagamento(0);
                    }
                }
                listener.update();
            }
        });

        tbDinheiro = (ToggleButton) v.findViewById(R.id.tb_dinheiro);
        tbDinheiro.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

                if (isChecked) {
                    PedidoActivity.carrinho.getPedido().setPagamento(Pedido.PAGAMENTO_DINHEIRO);
                    tbCartao.setChecked(false);
                    edTroco.setVisibility(View.VISIBLE);
                } else {
                    edTroco.setVisibility(View.GONE);
                    if (PedidoActivity.carrinho.getPedido().getPagamento() == Pedido.PAGAMENTO_DINHEIRO) {
                        PedidoActivity.carrinho.getPedido().setPagamento(0);
                    }
                }
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
        int pagamento = PedidoActivity.carrinho.getPedido().getPagamento();
        if (pagamento == Pedido.PAGAMENTO_CARTAO) {
            return true;

        } else if (pagamento == Pedido.PAGAMENTO_DINHEIRO) {
            try {
                float troco = Float.parseFloat(edTroco.getText().toString());
                if (troco > 0)
                    PedidoActivity.carrinho.getPedido().setTroco(troco);
            } catch (NumberFormatException ex) {
                ex.printStackTrace();
            }
            return true;
        }
        return false;
    }
}
