package com.edvaldotsi.fastfood.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import com.edvaldotsi.fastfood.PedidoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.ToolbarActivity;
import com.edvaldotsi.fastfood.dao.ProdutoDAO;
import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.util.Helper;

import java.text.DecimalFormat;
import java.util.List;

/**
 * Created by Edvaldo on 10/11/2015.
 */
public class DetalhesAdapter extends AbstractAdapter<DetalhesAdapter.ViewHolder, Detalhes> {

    private PedidoActivity listener;

    public DetalhesAdapter(Context context, List<Detalhes> items) {
        super(context, items);
        this.listener = (PedidoActivity) context;
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, int position, final Detalhes item) {
        holder.tvNome.setText(item.getProduto().getNome());
        holder.tvValor.setText(Helper.formatNumber(item.getValorTotal(), "R$ "));
        holder.tvQuantidade.setText(String.valueOf(item.getQuantidade()));

        holder.btFavorito.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // TODO: Precisa ser implementado corretamente

                listener.showMessage("Produto adicionado aos favoritos");
            }
        });

        holder.btAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                item.incrementar();
                notifyDataSetChanged();
                listener.update();
            }
        });
        holder.btDel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                item.decrementar();
                notifyDataSetChanged();
                listener.update();
            }
        });
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_detalhes, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView tvNome;
        public TextView tvValor;

        public ImageButton btFavorito;

        public ImageButton btAdd;
        public TextView tvQuantidade;
        public ImageButton btDel;

        public ViewHolder(View v) {
            super(v);

            tvNome = (TextView) v.findViewById(R.id.tv_nome);
            tvValor = (TextView) v.findViewById(R.id.tv_valor);

            btFavorito = (ImageButton) v.findViewById(R.id.bt_favorito);

            btAdd = (ImageButton) v.findViewById(R.id.bt_add);
            tvQuantidade = (TextView) v.findViewById(R.id.tv_quantidade);
            btDel = (ImageButton) v.findViewById(R.id.bt_del);
        }
    }
}
