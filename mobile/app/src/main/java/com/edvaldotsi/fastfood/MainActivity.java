package com.edvaldotsi.fastfood;

import android.app.SearchManager;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.StaggeredGridLayoutManager;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.edvaldotsi.fastfood.adapter.ProdutoAdapter;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.fragment.NavigationDrawerFragment;
import com.edvaldotsi.fastfood.model.Carrinho;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.model.Pedido;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.CircleTransform;
import com.google.gson.Gson;
import com.squareup.picasso.Picasso;

import org.json.JSONException;

import java.util.Arrays;
import java.util.List;

public class MainActivity extends ToolbarActivity {

    private SharedPreferences settings;

    private Cliente cliente;

    private NavigationDrawerFragment navigation;

    private ImageView ivPerfil;
    private TextView tvPerfilNome;
    private TextView tvPerfilEmail;
    private RecyclerView rvProduto;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_main);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle(getString(R.string.app_name));
        getToolbar().setSubtitle("Produtos");

        init();
        getViews();

        ServerRequest request = new ServerRequest(this, this);
        request.send("/produtos");

        try {
            cliente = ContaDAO.getCliente();

            String imagem = getResources().getString(R.string.server_host) + cliente.getImagem();
            Picasso.with(this).load(imagem).error(R.drawable.sem_imagem).resize(140, 140).centerCrop().transform(new CircleTransform()).into(ivPerfil);
            tvPerfilNome.setText(cliente.getNome());
            tvPerfilEmail.setText(cliente.getEmail());
        } catch (NullPointerException ex) {
            ex.printStackTrace();
        }

        settings = getSharedPreferences("cliente", 0);
        PedidoActivity.carrinho = new Carrinho(new Pedido(ContaDAO.getCliente()), null);
    }

    private void init() {
        navigation = (NavigationDrawerFragment) getSupportFragmentManager().findFragmentById(R.id.fragment_navigation_drawer);
        navigation.setup(R.id.fragment_navigation_drawer, (DrawerLayout) findViewById(R.id.dlMain), getToolbar());

        ListView lvNavigation = (ListView) findViewById(R.id.lvNavigation);
        lvNavigation.setAdapter(new NavigationAdapter(this, navigation));
        lvNavigation.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                switch (position) {
                    case 0:
                        telaConta();
                        break;
                    case 1:
                        Intent i = new Intent(MainActivity.this, ContaActivity.class);
                        i.putExtra("tabIndex", 1);
                        startActivity(i);
                        break;
                    case 4:
                        sair();
                        break;
                }
                navigation.close();
            }
        });
    }

    private void sair() {
        SharedPreferences.Editor editor = settings.edit();
        editor.remove("email");
        editor.remove("senha");
        editor.apply();
        editor.commit();
        finish();
    }

    private void telaConta() {
        startActivity(new Intent(this, ContaActivity.class));
    }

    private void getViews() {
        ivPerfil = (ImageView) findViewById(R.id.ivPerfil);
        tvPerfilNome = (TextView) findViewById(R.id.tvPerfilNome);
        tvPerfilEmail = (TextView) findViewById(R.id.tvPerfilEmail);
        rvProduto = (RecyclerView) findViewById(R.id.rv_produto);
    }

    private void telaDetalhes(Produto p) {
        Intent i = new Intent(this, ProdutoActivity.class);
        i.putExtra("produto", p);
        startActivity(i);
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        if (Intent.ACTION_SEARCH.equalsIgnoreCase(intent.getAction())) {
            String query = intent.getStringExtra(SearchManager.QUERY);

            getToolbar().setTitle("Pesquisar");
            getToolbar().setSubtitle(query);

            ServerRequest request = new ServerRequest(this, this);
            request.addParam("busca", query);
            request.send("/produtos");
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case R.id.actPesquisa:
                onSearchRequested();
                break;

            case R.id.action_finalizar:
                finalizarPedido();
                break;
        }

        return true;
    }

    private void finalizarPedido() {

        startActivity(new Intent(this, PedidoActivity.class));

        /*
        PostData data = new PostData();
        data.put("data", gson.toJson(carrinho));
        System.out.println(gson.toJson(carrinho));

        ServerRequest request = new ServerRequest(this, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {
                carrinho = new Carrinho(new Pedido(cliente), null);
                showMessage("Pedido finalizado e enviado");
            }

            @Override
            public void onResponseError(ServerResponse response) {}

            @Override
            public void onRequestError(ServerResponse response) {}
        }, ServerRequest.METHOD_POST);
        request.send("/pedidos", data);
        */
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {

        Gson gson = new Gson();
        try {
            Produto[] arr = gson.fromJson(response.getJSONArray("data").toString(), Produto[].class);
            List<Produto> produtos = Arrays.asList(arr);

            StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
            llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
            rvProduto.setLayoutManager(llm);
            ProdutoAdapter adapter = new ProdutoAdapter(this, produtos) {

                @Override
                protected void onItemClickListener(int position, int layoutPosition) {
                    telaDetalhes(this.getItem(position));
                }
            };
            rvProduto.setAdapter(adapter);
        } catch (JSONException ex) {
            showMessage(ex.getMessage());
        }
    }

    private class NavigationAdapter extends BaseAdapter {

        private NavigationDrawerFragment navigation;
        private LayoutInflater inflater;

        private String[] titles = {
                "Minha conta",
                "Meus endereços",
                "Meus favoritos",
                "Configurações",
                "Sair"
        };
        private int[] images = {
                R.drawable.ic_conta,
                R.drawable.ic_endereco,
                R.drawable.ic_favorito,
                R.drawable.ic_configuracao,
                R.drawable.ic_conta
        };

        public NavigationAdapter(Context context, NavigationDrawerFragment navigation) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            this.navigation = navigation;
        }

        @Override
        public int getCount() {
            return titles.length;
        }

        @Override
        public Object getItem(int position) {
            return titles[position];
        }

        @Override
        public long getItemId(int position) {
            return position;
        }

        @Override
        public View getView(int position, View view, ViewGroup parent) {
            if (view == null)
                view = inflater.inflate(R.layout.navigation_list_item, parent, false);

            ((ImageView) view.findViewById(R.id.ivIcone)).setImageResource(images[position]);
            ((TextView) view.findViewById(R.id.tvTitulo)).setText(titles[position]);

            return view;
        }
    }
}
