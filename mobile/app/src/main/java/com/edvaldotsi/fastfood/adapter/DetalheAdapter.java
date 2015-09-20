package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.model.ProdutoItem;

import java.util.List;

/**
 * Created by Edvaldo on 28/08/2015.
 */
public class DetalheAdapter extends AbstractAdapter<ProdutoItem> {

    public DetalheAdapter(Context context, List<ProdutoItem> objects) {
        super(context, R.layout.list_item_detalhe, objects);
    }

    @Override
    public View customView(int position, View view, ViewGroup parent, ProdutoItem produtoItem) {

        ((TextView) view.findViewById(R.id.tvNome)).setText(produtoItem.getItem().getNome());
        ((TextView) view.findViewById(R.id.tvQuantidade)).setText(String.valueOf(produtoItem.getQuantidade()));

        return view;
    }
}
