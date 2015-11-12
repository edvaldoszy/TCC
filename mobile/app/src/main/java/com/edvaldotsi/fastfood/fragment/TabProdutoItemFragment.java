package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.StaggeredGridLayoutManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.edvaldotsi.fastfood.ProdutoActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.adapter.ProdutoItemAdapter;
import com.edvaldotsi.fastfood.model.ProdutoItem;

import java.util.List;

public class TabProdutoItemFragment extends Fragment {

    private Activity activity;

    private RecyclerView rvItens;

    public static TabProdutoItemFragment newInstance() {
        return new TabProdutoItemFragment();
    }

    public TabProdutoItemFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_tab_produto_item, container, false);

        rvItens = (RecyclerView) v.findViewById(R.id.rv_itens);
        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rvItens.setLayoutManager(llm);

        update();
        return v;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
    }

    private void update() {
        List<ProdutoItem> itens = ProdutoActivity.getDetalhes().getItens();
        rvItens.setAdapter(new ProdutoItemAdapter(activity, itens));
    }
}
