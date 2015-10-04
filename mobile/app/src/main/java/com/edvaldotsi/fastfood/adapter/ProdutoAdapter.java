package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Produto;

import java.text.DecimalFormat;
import java.util.List;

/**
 * Created by Edvaldo on 05/09/2015.
 */
public class ProdutoAdapter extends AbstractAdapter<Produto> {

    private DecimalFormat df = new DecimalFormat("0.00");

    public ProdutoAdapter(Context context, List<Produto> objects) {
        super(context, R.layout.list_item_produto, objects);
    }

    @Override
    public View customView(int position, View view, ViewGroup parent, Produto produto) {
        
        ((TextView) view.findViewById(R.id.tvNome)).setText(produto.getNome());
        ((TextView) view.findViewById(R.id.tvValor)).setText("R$ " + df.format(produto.getValor()));
        ((TextView) view.findViewById(R.id.tvDescricao)).setText(produto.getDescricao());

        return view;
    }
}
