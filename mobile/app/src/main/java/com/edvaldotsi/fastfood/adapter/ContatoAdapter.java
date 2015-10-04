package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Contato;

import java.util.List;

/**
 * Created by Edvaldo on 25/09/2015.
 */
public class ContatoAdapter extends AbstractAdapter<Contato> {

    public ContatoAdapter(Context context, List<Contato> objects) {
        super(context, R.layout.list_item_contato, objects);
    }

    @Override
    public View customView(int position, View view, ViewGroup parent, Contato item) {
        ((TextView) view.findViewById(R.id.tv_telefone)).setText(item.getTelefone());
        return view;
    }
}
