package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.util.Helper;

import java.util.List;

/**
 * Created by Edvaldo on 10/12/2015.
 */
public class MeusPedidosAdapter extends AbstractAdapter<MeusPedidosAdapter.ViewHolder, Pedido> {

    private static final String[] SITUACAO = {"", " (aguardando)", " (fechado)", " (em produção)"};

    public MeusPedidosAdapter(Context context) {
        super(context);
    }

    public MeusPedidosAdapter(Context context, List<Pedido> items) {
        super(context, items);
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, int position, Pedido pedido) {
        int situacao = Character.getNumericValue(pedido.getSituacao());
        holder.tvProdutos.setText(
                String.valueOf(pedido.getProdutos()) + (pedido.getProdutos() > 1 ? " produtos" : " produto")
                + SITUACAO[situacao]
        );
        holder.tvValor.setText(Helper.formatNumber(pedido.getValor(), "R$ "));
        holder.tvEndereco.setText(pedido.getEndereco().toString());
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_pedido, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView tvProdutos;
        public TextView tvValor;
        public TextView tvEndereco;

        public ViewHolder(View v) {
            super(v);

            tvProdutos = (TextView) v.findViewById(R.id.tv_produtos);
            tvValor = (TextView) v.findViewById(R.id.tv_valor);
            tvEndereco = (TextView) v.findViewById(R.id.tv_endereco);
        }
    }
}
