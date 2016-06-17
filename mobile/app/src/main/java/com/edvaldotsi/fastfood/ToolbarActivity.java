package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.StaggeredGridLayoutManager;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.widget.Toast;

import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.google.gson.Gson;

/**
 * Created by Edvaldo on 05/09/2015.
 */
public abstract class ToolbarActivity extends AppCompatActivity implements ServerRequest.RequestListener {

    private Toolbar toolbar;
    private int layout;

    protected Gson gson = new Gson();

    public void setLayout(int resource) {
        layout = resource;
    }

    public Toolbar getToolbar() {
        return toolbar;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(layout);

        toolbar = (Toolbar) findViewById(R.id.toolbar_main);
        toolbar.setTitle("FastFood");
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
    }

    protected RecyclerView getRecyclerView(int resource) {
        RecyclerView rv = (RecyclerView) findViewById(resource);

        StaggeredGridLayoutManager llm = new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL);
        llm.setGapStrategy(StaggeredGridLayoutManager.GAP_HANDLING_NONE);
        rv.setLayoutManager(llm);

        return rv;
    }

    public void showMessage(String message) {
        Toast.makeText(this, message, Toast.LENGTH_LONG).show();
    }

    @Override
    public void onResponseError(ServerResponse response) {

        if (response.getCode() == 401) {
            showMessage("Sua sessão expirou, faça login novamente");
        } else {
            showMessage("Erro ao completar operação, tente novamente mais tarde");
        }

        Log.e("RESPONSE ERROR", response.getMessage());
        System.out.println(response.getOutput());
    }

    @Override
    public void onRequestError(ServerResponse response) {

        showMessage("Erro ao completar operação, tente novamente mais tarde");

        Log.e("REQUEST ERROR", response.getMessage());
        System.out.println(response.getOutput());
    }
}
