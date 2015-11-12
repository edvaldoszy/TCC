package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.util.CircleTransform;
import com.squareup.picasso.Picasso;

import java.text.DecimalFormat;
import java.util.List;

/**
 * Created by Edvaldo on 05/09/2015.
 */
public class ProdutoAdapter extends AbstractAdapter<ProdutoAdapter.ViewHolder, Produto> {

    private DecimalFormat df = new DecimalFormat("0.00");

    public ProdutoAdapter(Context context, List<Produto> item) {
        super(context, item);
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, int position, Produto item) {
        holder.tvNome.setText(item.getNome());
        holder.tvValor.setText("R$ " + df.format(item.getValor()));
        holder.tvDescricao.setText(item.getDescricao());

        if (item.getImagem() != null && !"".equals(item.getImagem())) {
            String imagem = mContext.getResources().getString(R.string.server_host) + item.getImagem();
            System.out.println(imagem);
            Picasso.with(mContext).load(imagem).error(R.drawable.sem_imagem).resize(60, 60).centerCrop().transform(new CircleTransform()).into(holder.imProduto);
        }
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_produto, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView tvNome;
        public TextView tvValor;
        public TextView tvDescricao;
        public ImageView imProduto;

        public ViewHolder(View v) {
            super(v);

            tvNome = (TextView) v.findViewById(R.id.tv_nome);
            tvValor = (TextView) v.findViewById(R.id.tv_valor);
            tvDescricao = (TextView) v.findViewById(R.id.tv_descricao);
            imProduto = (ImageView) v.findViewById(R.id.im_produto);
        }
    }
}
