package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Endereco;

import java.util.List;

/**
 * Created by Edvaldo on 24/09/2015.
 */
public class EnderecoAdapter extends AbstractAdapter<EnderecoAdapter.ViewHolder, Endereco> {

    public EnderecoAdapter(Context context, List<Endereco> items) {
        super(context, items);
    }

    @Override
    protected void onBindViewHolder(final ViewHolder holder, int position, final Endereco endereco) {
        holder.edEndereco.setText(endereco.toString());
        holder.edCidade.setText(endereco.getCidade().toString());
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        return new ViewHolder(inflate(R.layout.card_endereco, parent, false));
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView edEndereco;
        public TextView edCidade;

        public ViewHolder(View v) {
            super(v);

            edEndereco = (TextView) v.findViewById(R.id.ed_endereco);
            edCidade = (TextView) v.findViewById(R.id.ed_cidade);
        }
    }
}
