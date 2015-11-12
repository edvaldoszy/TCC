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
public class ContatoAdapter extends AbstractAdapter<ContatoAdapter.ViewHolder, Contato> {

    public ContatoAdapter(Context context, List<Contato> items) {
        super(context, items);
    }

    @Override
    protected void onBindViewHolder(ViewHolder holder, int position, Contato contato) {
        holder.tvContato.setText(contato.toString());
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = mLayoutInflater.inflate(R.layout.card_contato, parent, false);
        return new ViewHolder(v);
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public TextView tvContato;

        public ViewHolder(View v) {
            super(v);

            tvContato = (TextView) v.findViewById(R.id.tv_contato);
        }
    }
}
