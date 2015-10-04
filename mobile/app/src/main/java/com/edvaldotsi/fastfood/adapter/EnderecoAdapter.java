package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Endereco;

import java.util.List;

/**
 * Created by Edvaldo on 24/09/2015.
 */
public class EnderecoAdapter extends AbstractAdapter<Endereco> {

    public EnderecoAdapter(Context context, List<Endereco> objects) {
        super(context, R.layout.list_item_endereco, objects);
    }

    @Override
    public View customView(int position, View view, ViewGroup parent, Endereco item) {

        ((TextView) view.findViewById(R.id.tv_endereco)).setText(item.toString());
        ((TextView) view.findViewById(R.id.tv_cidade)).setText(item.getBairro() + ", " + item.getCidade().toString());

        return view;
    }
}
