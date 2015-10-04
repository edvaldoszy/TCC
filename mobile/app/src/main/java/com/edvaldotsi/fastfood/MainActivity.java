package com.edvaldotsi.fastfood;

import android.app.SearchManager;
import android.content.Context;
import android.content.Intent;
import android.support.v4.widget.DrawerLayout;
import android.os.Bundle;
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
import android.widget.Toast;

import com.edvaldotsi.fastfood.adapter.ProdutoAdapter;
import com.edvaldotsi.fastfood.dao.ClienteDAO;
import com.edvaldotsi.fastfood.fragment.NavigationDrawerFragment;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.Request;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.RoundedImage;

public class MainActivity extends ToolbarActivity {

    private NavigationDrawerFragment navigation;

    private Cliente cliente;

    private ImageView ivPerfil;
    private TextView tvPerfil;
    private ListView lvProdutos;

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

        //ClienteDAO dao = new ClienteDAO(this);
        //cliente = dao.getUsuarioLogado();
        cliente = new Cliente(1, "Edvaldo Szymonek");

        ivPerfil.setImageDrawable(new RoundedImage(this, R.drawable.edvaldo));
        tvPerfil.setText(cliente.getNome());
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
                        startActivity(new Intent(MainActivity.this, ContaActivity.class));
                        break;
                    case 1:
                        Intent i = new Intent(MainActivity.this, ContaActivity.class);
                        i.putExtra("tabIndex", 1);
                        startActivity(i);
                        break;
                }
                navigation.close();
            }
        });
    }

    private void getViews() {
        ivPerfil = (ImageView) findViewById(R.id.ivPerfil);
        tvPerfil = (TextView) findViewById(R.id.tvPerfil);
        lvProdutos = (ListView) findViewById(R.id.lvProdutos);
    }

    private void detalhes(Produto p) {
        Intent i = new Intent(this, DetalheActivity.class);
        i.putExtra("produto", p);
        startActivity(i);
    }

    public void pesquisar(Intent intent) {
        if (Intent.ACTION_SEARCH.equalsIgnoreCase(intent.getAction())) {
            String query = intent.getStringExtra(SearchManager.QUERY);

            getToolbar().setTitle("Pesquisar");
            getToolbar().setSubtitle(query);
        }
    }

    @Override
    protected void onNewIntent(Intent intent) {
        super.onNewIntent(intent);
        pesquisar(intent);
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
        }

        return true;
    }

    @Override
    public void onResponseSuccess(String message, ServerResponse response) {
        try {
            lvProdutos.setAdapter(new ProdutoAdapter(this, response.getProdutos()));
            lvProdutos.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    detalhes((Produto) parent.getItemAtPosition(position));
                }
            });
        } catch (Exception ex) {
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
                "Configurações"
        };
        private int[] images = {
                R.drawable.ic_conta,
                R.drawable.ic_endereco,
                R.drawable.ic_favorito,
                R.drawable.ic_configuracao
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
