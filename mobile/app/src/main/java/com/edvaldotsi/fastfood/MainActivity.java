package com.edvaldotsi.fastfood;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.request.RequestInterface;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

import org.json.JSONException;

import java.util.List;

public class MainActivity extends AppCompatActivity implements RequestInterface {

    private ListView lvProdutos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        lvProdutos = (ListView) findViewById(R.id.lvProdutos);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    private void buildList(List<Produto> produtos) {
        ArrayAdapter<Produto> adapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, produtos);
        lvProdutos.setAdapter(adapter);
    }

    private List<Produto> parseJsonProduto(String response) {
        return null;
    }

    @Override
    public void afterRequest(ServerResponse response) {
        try {
            buildList(response.getProdutos());
            System.out.println(response);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public void sendRequest(View v) {
        ServerRequest request = new ServerRequest(this, this);
        request.execute("http://192.168.0.16/admin/index/mobile");
    }
}
