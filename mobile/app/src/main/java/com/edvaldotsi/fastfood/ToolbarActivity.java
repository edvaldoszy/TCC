package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
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

    private Toast toast;

    protected Gson gson;

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

        toast = Toast.makeText(this, "", Toast.LENGTH_SHORT);
        gson = new Gson();
    }

    public void showMessage(String str) {
        toast.setText(str);
        toast.show();
    }

    @Override
    public void onResponseError(ServerResponse response) {
        showMessage(response.getMessage());
        Log.e("RESPONSE ERROR", response.getMessage());
        System.out.println(response.getOutput());
    }

    @Override
    public void onRequestError(ServerResponse response) {
        showMessage(response.getMessage());
        Log.e("REQUEST ERROR", response.getMessage());
        System.out.println(response.getOutput());
    }
}
