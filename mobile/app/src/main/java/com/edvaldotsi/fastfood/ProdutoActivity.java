package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.fragment.TabProdutoFragment;
import com.edvaldotsi.fastfood.fragment.TabProdutoItemFragment;
import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.view.SlidingTabLayout;

public class ProdutoActivity extends ToolbarActivity {

    private static Detalhes detalhes;
    private boolean edicao = false;

    public static Detalhes getDetalhes() {
        return detalhes;
    }

    private PagerAdapter adapter;
    private ViewPager viewPager;
    private SlidingTabLayout tabLayout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_produto);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle(getString(R.string.title_activity_detalhe));

        try {
            Produto produto = (Produto) getIntent().getSerializableExtra("produto");
            getToolbar().setTitle(produto.getNome());

            ServerRequest request = new ServerRequest(this, this);
            request.send("/produtos/" + produto.getCodigo() + "/detalhes");
        } catch (NullPointerException ex) {

            try {

                detalhes = (Detalhes) getIntent().getSerializableExtra("detalhes");
                createAdater();
                edicao = true; // Define se o produto aberto está para edução
                // Produtos para edição são os que já estão no carrinho e estão sendo editados
            } catch (NullPointerException ex1) {
                ex1.printStackTrace();
                showMessage("Erro ao carregar informações do produto");
                finish();
            }
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_default, menu);
        menu.getItem(0).setVisible(false);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;

            case R.id.act_salvar:
                finalizar();
                break;
        }

        return true;
    }

    private void finalizar() {

        if (edicao) {
            Intent intent = new Intent();
            intent.putExtra("detalhes", detalhes);
            setResult(10, intent);
        } else {
            PedidoActivity.carrinho.addProduto(detalhes);
            showMessage("Produto adicionado ao carrinho");
        }

        detalhes = null;
        finish();
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {

        detalhes = gson.fromJson(response.getOutput(), Detalhes.class);
        createAdater();
    }

    private void createAdater() {
        adapter = new PagerAdapter(getSupportFragmentManager());
        viewPager = (ViewPager) findViewById(R.id.view_pager);
        viewPager.setAdapter(adapter);
        viewPager.setOffscreenPageLimit(adapter.getCount());

        tabLayout = (SlidingTabLayout) findViewById(R.id.tab_layout);
        tabLayout.setViewPager(viewPager);
    }

    private class PagerAdapter extends FragmentPagerAdapter {

        private String[] titles = {"INFORMAÇÕES", "ITENS"};
        private Fragment[] fragments = {
                TabProdutoFragment.newInstance(),
                TabProdutoItemFragment.newInstance()
        };

        public PagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public CharSequence getPageTitle(int position) {
            return titles[position];
        }

        @Override
        public Fragment getItem(int position) {
            return fragments[position];
        }

        @Override
        public int getCount() {
            return fragments.length;
        }
    }
}
