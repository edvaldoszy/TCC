package com.edvaldotsi.fastfood;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;

import com.edvaldotsi.fastfood.model.Produto;

public class DetalheActivity extends AppCompatActivity {

    private Toolbar toolbar;

    private Produto produto;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detalhe);

        toolbar = (Toolbar) findViewById(R.id.mainToolbar);
        toolbar.setTitle("Detalhes do produto");
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        try {
            produto = (Produto) getIntent().getSerializableExtra("produto");
            toolbar.setTitle(produto.getNome());
        } catch (NullPointerException ex) {}

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_detalhe, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case android.R.id.home:
                finish();
                break;
        }

        return true;
    }
}
