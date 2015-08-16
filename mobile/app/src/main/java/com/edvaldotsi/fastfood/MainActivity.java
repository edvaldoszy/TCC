package com.edvaldotsi.fastfood;

import android.content.ContentValues;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
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

    public void sendLoginRequest(View v) {

        try {
            final URL url = new URL("http://192.168.0.16/login/index/json");

            new Thread() {
                @Override
                public void run() {
                    try {
                        HttpURLConnection con = (HttpURLConnection) url.openConnection();
                        con.setDoOutput(true);
                        con.setRequestMethod("POST");

                        ContentValues cv = new ContentValues();
                        cv.put("login", "edvaldo");
                        cv.put("senha", "123");

                        DataOutputStream data = new DataOutputStream(con.getOutputStream());
                        data.writeBytes(cv.toString().replace(' ', '&'));

                        BufferedReader reader = new BufferedReader(new InputStreamReader(con.getInputStream()));
                        System.out.println(reader.readLine());
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
            }.start();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
