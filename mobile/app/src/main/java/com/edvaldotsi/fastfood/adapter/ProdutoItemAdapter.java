package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.ProdutoItem;
import com.edvaldotsi.fastfood.util.Helper;

import java.text.DecimalFormat;
import java.util.List;

/**
 * Created by Edvaldo on 28/08/2015.
 */
public class ProdutoItemAdapter extends AbstractAdapter<ProdutoItemAdapter.ViewHolder, ProdutoItem> {

    public ProdutoItemAdapter(Context context, List<ProdutoItem> items) {
        super(context, items);
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, final int position, final ProdutoItem item) {
        holder.tvNome.setText(item.getNome());
        holder.tvValor.setText("R$ " + Helper.formatNumber(item.getValor()));
        holder.tvQuantidade.setText(String.valueOf(item.getQuantidade()));
        holder.tvAdicional.setText(item.isAdicional() ? "Adicional" : "Composição");

        holder.btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                item.incrementar();
                notifyDataSetChanged();
            }
        });
        holder.btnDel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                item.decrementar();
                notifyDataSetChanged();
            }
        });
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_produto_item, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView tvNome;
        public TextView tvValor;
        public TextView tvAdicional;
        public TextView tvQuantidade;

        public ImageButton btnAdd, btnDel;

        public ViewHolder(View v) {
            super(v);

            tvNome = (TextView) v.findViewById(R.id.tv_nome);
            tvValor = (TextView) v.findViewById(R.id.tv_valor);
            tvAdicional = (TextView) v.findViewById(R.id.tv_adicional);
            tvQuantidade = (TextView) v.findViewById(R.id.tv_quantidade);

            btnAdd = (ImageButton) v.findViewById(R.id.bt_add);
            btnDel = (ImageButton) v.findViewById(R.id.bt_del);
        }
    }
}
