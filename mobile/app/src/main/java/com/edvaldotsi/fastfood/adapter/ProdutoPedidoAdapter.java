package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.util.CircleTransform;
import com.edvaldotsi.fastfood.util.Helper;
import com.squareup.picasso.Picasso;

import java.util.List;

/**
 * Created by Edvaldo on 14/12/2015.
 */
public class ProdutoPedidoAdapter extends AbstractAdapter<ProdutoPedidoAdapter.ViewHolder, Produto> {

    public ProdutoPedidoAdapter(Context context) {
        super(context);
    }

    public ProdutoPedidoAdapter(Context context, List<Produto> items) {
        super(context, items);
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, int position, Produto produto) {
        holder.tvNome.setText(produto.getNome());

        if (produto.getImagem() != null && !"".equals(produto.getImagem())) {
            String imagem = Helper.loadImage(mContext, produto.getImagem(), 60, 60);
            Picasso.with(mContext).load(imagem).error(R.drawable.sem_imagem).resize(60, 60).centerCrop().transform(new CircleTransform()).into(holder.imProduto);
        }
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_produto_pedido, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public final TextView tvNome;
        public final ImageView imProduto;

        public ViewHolder(View v) {
            super(v);

            imProduto = (ImageView) v.findViewById(R.id.im_produto);
            tvNome = (TextView) v.findViewById(R.id.tv_nome);
        }
    }
}
