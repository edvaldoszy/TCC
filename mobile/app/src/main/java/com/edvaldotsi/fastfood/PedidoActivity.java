package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.fragment.TabEnderecoEntregaFragment;
import com.edvaldotsi.fastfood.fragment.TabPagamentoFragment;
import com.edvaldotsi.fastfood.fragment.TabProdutoCarrinhoFragment;
import com.edvaldotsi.fastfood.model.Carrinho;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.Helper;
import com.edvaldotsi.fastfood.view.SlidingTabLayout;

public class PedidoActivity extends ToolbarActivity {

    public static Carrinho carrinho;

    private PagerAdapter adapter;
    private ViewPager viewPager;
    private SlidingTabLayout tabLayout;

    private TextView tvValorTotal;
    private TextView tvFormaPagamento;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_pedido);
        super.onCreate(savedInstanceState);

        getToolbar().setTitle("Meu carrinho");
        getToolbar().setSubtitle("Produtos");

        createAdater();

        tvValorTotal = (TextView) findViewById(R.id.tv_valor_total);
        tvFormaPagamento = (TextView) findViewById(R.id.tv_forma_pagamento);
        update();
    }

    public void update() {
        tvValorTotal.setText("R$ " + Helper.formatNumber(carrinho.getValorTotal()));

        // Obtem a forma de pagamento do array de Strings da classe Pedido para exibição para o usuário
        tvFormaPagamento.setText(Pedido.FORMAS_PAGAMENTO[carrinho.getPedido().getPagamento()]);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_pedido, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {

            case android.R.id.home:
                finish();
                break;

            case R.id.mn_proximo:
                proximo();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    private void createAdater() {
        adapter = new PagerAdapter(getSupportFragmentManager());
        viewPager = (ViewPager) findViewById(R.id.view_pager);
        viewPager.setAdapter(adapter);
        viewPager.setOffscreenPageLimit(adapter.getCount());

        tabLayout = (SlidingTabLayout) findViewById(R.id.tab_layout);
        tabLayout.setViewPager(viewPager);
    }

    public void proximo() {
        int pagina = viewPager.getCurrentItem();

        // Verifica se não estiver no ultimo fragment, move para o próximo, senão executa o método finalizar()
        if (pagina < viewPager.getAdapter().getCount() - 1) {
            viewPager.setCurrentItem((pagina + 1));
        } else {
            finalizar();
        }
    }

    private void finalizar() {

        // Percorre todos os Fragments do adapter executando o método "validar()" que verifica se o fragment possui
        // os dados necessários para finalizar o pedido, caso contrário move para o fragment inválido e exibe uma mensagem
        for (int n = 0; n < adapter.getCount(); n++) {
            ValidacaoListener listener = (ValidacaoListener) adapter.getItem(n);
            if (!listener.validar()) {
                viewPager.setCurrentItem(n);

                switch (n) {

                    case 0: // Caso não exista produtos adicionados ao carrinho
                        showMessage("Você não possui produtos no carrinho");
                        break;

                    case 1: // Caso não tenha sido selecionado nenhum endereço para entrega
                        showMessage("Você precisa selecionar um endereço para entrega");
                        break;

                    case 2: // Caso não tenha sido selecionado nenhuma forma de pagamento
                        showMessage("Você precisa selecionar uma forma de pagamento");
                        break;
                }

                return;
            }
        }

        PostData data = new PostData();
        data.put("data", gson.toJson(carrinho));

        // Caso não tenha sido encontrado nenhum fragment inválido, finaliza e envia o pedido
        ServerRequest request = new ServerRequest(this, this, ServerRequest.METHOD_POST);
        request.send("/pedidos", data);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        PedidoActivity.carrinho = new Carrinho(new Pedido(ContaDAO.getCliente()), null);
        showMessage("Pedido finalizado e encaminhado para produção");
        finish();
    }

    private class PagerAdapter extends FragmentPagerAdapter {

        private String[] titles = {"PRODUTOS", "ENTREGA", "PAGAMENTO", "FINALIZAR"};
        private Fragment[] fragments = {
                TabProdutoCarrinhoFragment.newInstance(),
                TabEnderecoEntregaFragment.newInstance(),
                TabPagamentoFragment.newInstance()
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

    public interface ValidacaoListener {

        boolean validar();
    }
}
