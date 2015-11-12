package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.SeekBar;
import android.widget.TextView;

import com.edvaldotsi.fastfood.ProdutoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.model.Produto;
import com.squareup.picasso.Picasso;

import java.text.DecimalFormat;

public class TabProdutoFragment extends Fragment {

    private Activity activity;

    private Detalhes detalhes;

    private ImageView imProduto;
    private TextView tvNome;
    private TextView tvValor;
    private TextView tvQuantidade;

    private ImageButton btAdd, btDel;

    DecimalFormat df = new DecimalFormat("0.00");

    public static TabProdutoFragment newInstance() {
        return new TabProdutoFragment();
    }

    public TabProdutoFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_tab_produto, container, false);

        imProduto = (ImageView) v.findViewById(R.id.im_produto);
        tvNome = (TextView) v.findViewById(R.id.tv_nome);
        tvValor = (TextView) v.findViewById(R.id.tv_valor);
        tvQuantidade = (TextView) v.findViewById(R.id.tv_quantidade);

        btAdd = (ImageButton) v.findViewById(R.id.bt_add);
        btAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                detalhes.incrementar();
                tvQuantidade.setText(String.valueOf(detalhes.getQuantidade()));
                tvValor.setText("R$ " + df.format(detalhes.getValorTotal()));
            }
        });

        btDel = (ImageButton) v.findViewById(R.id.bt_del);
        btDel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                detalhes.decrementar();
                tvQuantidade.setText(String.valueOf(detalhes.getQuantidade()));
                tvValor.setText("R$ " + df.format(detalhes.getValorTotal()));
            }
        });

        update();

        return v;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
    }

    private void update() {
        detalhes = ProdutoActivity.getDetalhes();
        Produto produto = detalhes.getProduto();

        if (produto.getImagem() != null && !"".equals(produto.getImagem())) {
            // Calcula o tamanho da tela para redimensionar a imagem
            int width = (int) (getResources().getDisplayMetrics().widthPixels / getResources().getDisplayMetrics().density);

            // Calcula o tamanho do objeto ImageView para redimensionar a imagem
            int height = (int) (imProduto.getLayoutParams().height / getResources().getDisplayMetrics().density);

            String imagem = activity.getResources().getString(R.string.server_host) + produto.getImagem();
            System.out.println(imagem);
            Picasso.with(activity).load(imagem).resize(width, height).centerCrop().into(imProduto);
        }

        tvNome.setText(produto.getNome());
        tvValor.setText("R$ " + df.format(detalhes.getValorTotal()));

        tvQuantidade.setText(String.valueOf(detalhes.getQuantidade()));
    }
}
