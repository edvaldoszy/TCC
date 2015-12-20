package com.edvaldotsi.fastfood;

import android.content.Intent;
import android.content.SharedPreferences;
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
import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.Helper;
import com.edvaldotsi.fastfood.view.SlidingTabLayout;

import org.json.JSONException;

import java.util.Arrays;
import java.util.List;

public class PedidoActivity extends ToolbarActivity {

    public static Carrinho carrinho;
    private Carrinho carrinhoBackup;
    private Pedido pedido;

    private PagerAdapter adapter;
    private ViewPager viewPager;

    private TextView tvValorTotal;
    private TextView tvFormaPagamento;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_pedido);
        super.onCreate(savedInstanceState);

        getToolbar().setTitle("Meu carrinho");
        getToolbar().setSubtitle("Produtos");

        tvValorTotal = (TextView) findViewById(R.id.tv_valor_total);
        tvFormaPagamento = (TextView) findViewById(R.id.tv_forma_pagamento);

        pedido = (Pedido) getIntent().getSerializableExtra("pedido");
        if (pedido != null) {

            int size = carrinho.getDetalhes().size();
            if (size > 0)
                carrinhoBackup = new Carrinho(carrinho.getPedido(), carrinho.getDetalhes());

            ServerRequest request = new ServerRequest(this, new ServerRequest.RequestListener() {
                @Override
                public void onResponseSuccess(ServerResponse response) {

                    try {
                        String json = response.getJSONArray("detalhes").toString();
                        Detalhes[] a = response.decode(json, Detalhes[].class);

                        List<Detalhes> detalhesList = Arrays.asList(a);
                        carrinho.setPedido(pedido);
                        carrinho.setDetalhes(detalhesList);
                        createAdater();
                        update();
                    } catch (JSONException ex) {
                        ex.printStackTrace();
                    }
                }

                @Override
                public void onResponseError(ServerResponse response) {
                    PedidoActivity.this.onResponseError(response);
                }

                @Override
                public void onRequestError(ServerResponse response) {
                    PedidoActivity.this.onRequestError(response);
                }
            });
            request.send("/pedidos/" + pedido.getCodigo() + "/produtos");
        } else {
            createAdater();
            update();
        }
    }

    public void update() {
        tvValorTotal.setText(Helper.formatNumber(carrinho.getValorTotal(), "R$ "));

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

        SlidingTabLayout tabLayout = (SlidingTabLayout) findViewById(R.id.tab_layout);
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
        if (response.getCode() == 200) {

            /*
            SharedPreferences sp = getSharedPreferences("cliente", 0);
            SharedPreferences.Editor editor = sp.edit();
            editor.putInt("monitorar", true);
            editor.apply();

            // Inicia o serviço de monitoramento do pedido
            startService(new Intent(this, PedidoService.class));

            PedidoActivity.carrinho = new Carrinho(new Pedido(ContaDAO.getCliente()));
            showMessage("Pedido finalizado e encaminhado para produção");
            finish();
            */

            try {
                String json = response.getJSONObject("pedido").toString();
                Pedido pedido = response.decode(json, Pedido.class);

                SharedPreferences sp = getSharedPreferences("cliente", 0);
                SharedPreferences.Editor editor = sp.edit();
                editor.putInt("monitorar", pedido.getCodigo());
                editor.apply();

                // Inicia o serviço de monitoramento do pedido
                startService(new Intent(this, PedidoService.class));

                PedidoActivity.carrinho = new Carrinho(new Pedido(ContaDAO.getCliente()));
                showMessage("Pedido finalizado e encaminhado para produção");
                finish();

            } catch (JSONException ex) {
                showMessage("Erro ao realizar operação, tente novamente mais tarde");
            }
        } else {
            super.onResponseError(response);
        }
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

    @Override
    protected void onDestroy() {
        if (pedido != null)
            carrinho = (carrinhoBackup != null) ? carrinhoBackup : new Carrinho(new Pedido(ContaDAO.getCliente()));

        super.onDestroy();
    }
}
