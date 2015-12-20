package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.TextView;

import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Endereco;

import java.util.List;

/**
 * Created by Edvaldo on 11/11/2015.
 */
public class EnderecoEntregaAdapter extends AbstractAdapter<EnderecoEntregaAdapter.ViewHolder, Endereco> {

    private CheckBox lastChecked;
    private Endereco lastEnderecoChecked;

    public EnderecoEntregaAdapter(Context context, List<Endereco> items) {
        super(context, items);
    }

    // Retorna o endereço que foi selecionado pelo cliente
    public Endereco selecionado() {
        return lastEnderecoChecked;
    }

    @Override
    protected void onBindViewHolder(final ViewHolder holder, int position, final Endereco endereco) {

        holder.ckEntrega.setChecked(endereco.isEntrega());
        holder.edEndereco.setText(endereco.toString());
        holder.edCidade.setText(endereco.getCidade().toString());

        holder.ckEntrega.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (lastChecked != null && !lastEnderecoChecked.equals(endereco)) {
                    lastChecked.setChecked(false);
                    lastEnderecoChecked.setEntrega(false);
                }
                lastChecked = holder.ckEntrega;
                lastEnderecoChecked = endereco;
            }
        });

        holder.view.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                holder.ckEntrega.setChecked(!holder.ckEntrega.isChecked());
                endereco.setEntrega(!endereco.isEntrega());
            }
        });
    }

    @Override
    public ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        return new ViewHolder(inflate(R.layout.card_endereco_entrega, parent, false));
    }

    public class ViewHolder extends AbstractAdapter.AbstractViewHolder {

        public View view;
        public CheckBox ckEntrega;
        public TextView edEndereco;
        public TextView edCidade;

        public ViewHolder(View v) {
            super(v);

            view = v;
            ckEntrega = (CheckBox) v.findViewById(R.id.ck_entrega);
            edEndereco = (TextView) v.findViewById(R.id.ed_endereco);
            edCidade = (TextView) v.findViewById(R.id.ed_cidade);

        }
    }
}
