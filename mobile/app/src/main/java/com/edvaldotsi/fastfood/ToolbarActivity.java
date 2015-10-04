package com.edvaldotsi.fastfood;

import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.widget.Toast;

import com.edvaldotsi.fastfood.request.Request;
import com.edvaldotsi.fastfood.request.ServerResponse;

/**
 * Created by Edvaldo on 05/09/2015.
 */
public abstract class ToolbarActivity extends AppCompatActivity implements Request {

    private Toolbar toolbar;
    private int layout;

    private Toast toast;

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
    }

    protected void showMessage(String str) {
        toast.setText(str);
        toast.show();
    }

    @Override
    public void onRequestError(Exception ex) {
        showMessage("onRequestError");
    }

    @Override
    public void onResponseError(String message, ServerResponse response) {
        showMessage("onResponseError");
        Log.e("RESPONSE ERROR", message);
    }
}
