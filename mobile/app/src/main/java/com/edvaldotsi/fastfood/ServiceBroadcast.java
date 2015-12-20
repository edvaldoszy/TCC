package com.edvaldotsi.fastfood;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

/**
 * Created by Programação Web on 11/12/2015.
 */
public class ServiceBroadcast extends BroadcastReceiver {

    @Override
    public void onReceive(Context context, Intent intent) {
        SharedPreferences sp = context.getSharedPreferences("cliente", 0);
        if (sp.getInt("monitorar", 0) != 0) {
            intent = new Intent(context, PedidoService.class);
            context.startService(intent);
        }
    }
}
