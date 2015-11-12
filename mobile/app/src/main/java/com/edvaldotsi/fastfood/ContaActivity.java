package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.dao.ClienteDAO;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.fragment.TabClienteFragment;
import com.edvaldotsi.fastfood.fragment.TabContatoFragment;
import com.edvaldotsi.fastfood.fragment.TabEnderecoFragment;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.model.Conta;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.view.SlidingTabLayout;
import com.google.gson.Gson;

import org.json.JSONException;
import org.json.JSONObject;

public class ContaActivity extends ToolbarActivity {

    private PagerAdapter adapter;

    private SlidingTabLayout tabLayout;
    private ViewPager viewPager;

    private Conta conta;
    public static boolean updated = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        setLayout(R.layout.activity_conta);
        super.onCreate(savedInstanceState);
        getToolbar().setTitle(getString(R.string.title_activity_conta));
    }

    @Override
    protected void onResume() {
        super.onResume();

        if (!updated) {
            ServerRequest request = new ServerRequest(this, this);
            request.send("/clientes/" + ContaDAO.getCliente().getCodigo());
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_conta, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onResponseSuccess(ServerResponse response) {
        try {
            String json = response.getJSONObject("conta").toString();
            Conta conta = response.decode(json, Conta.class);
            ContaDAO.setConta(conta);
            createAdapter();
            updated = true;
        } catch (JSONException ex) {
            ex.printStackTrace();
        }
    }

    private void createAdapter() {
        adapter = new PagerAdapter(getSupportFragmentManager());
        viewPager = (ViewPager) findViewById(R.id.viewPager);
        viewPager.setAdapter(adapter);

        tabLayout = (SlidingTabLayout) findViewById(R.id.tabLayout);
        tabLayout.setViewPager(viewPager);
    }

    private class PagerAdapter extends FragmentPagerAdapter {

        private String[] titles;
        private Fragment[] fragments = {
                TabClienteFragment.newInstance(),
                TabEnderecoFragment.newInstance(),
                TabContatoFragment.newInstance()
        };

        public PagerAdapter(FragmentManager fm) {
            super(fm);
            titles = getResources().getStringArray(R.array.tabs_title);
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

    @Override
    protected void onDestroy() {
        super.onDestroy();
        updated = false;
    }
}
