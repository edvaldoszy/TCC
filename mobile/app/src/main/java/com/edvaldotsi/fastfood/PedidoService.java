package com.edvaldotsi.fastfood;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.drawable.BitmapDrawable;
import android.os.IBinder;
import android.support.annotation.Nullable;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.NotificationCompat;
import android.util.Log;

import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;

/**
 * Created by Programação Web on 11/12/2015.
 */
public class PedidoService extends Service {

    private boolean iniciado = false;
    private Worker worker;

    private int codigo;

    @Override
    public void onCreate() {
        super.onCreate();
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        SharedPreferences sp = getSharedPreferences("cliente", 0);
        codigo = sp.getInt("monitorar", 0);

        if (!iniciado && codigo != 0) {
            worker = new Worker(startId);
            worker.start();
            iniciado = true;
            Log.i("PEDIDO_SERVICE", "SERVICO INICIADO");
        }
        return START_STICKY;
    }

    @Nullable
    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        worker.ativo = false;
        Log.i("PEDIDO_SERVICE", "SERVICO DESTRUIDO");
    }

    private void notificar() {
        NotificationCompat.Builder builder = new NotificationCompat.Builder(this);
        builder.setContentTitle("FastFood");
        builder.setContentText("Avalie seu pedido e ajude-nos");
        builder.setSmallIcon(R.drawable.ic_app_icon, 10);

        BitmapDrawable drawable = (BitmapDrawable) ContextCompat.getDrawable(this, R.drawable.ic_app_icon);
        builder.setLargeIcon(drawable.getBitmap());

        Intent i = new Intent(this, ProdutosPedidoActivity.class);
        i.putExtra("pedido_codigo", codigo);
        PendingIntent intent = PendingIntent.getActivity(this, 0, i, 0);
        builder.setContentIntent(intent);

        Notification no = builder.build();
        no.vibrate = new long[]{150, 300, 150, 300};

        NotificationManager manager = (NotificationManager) getSystemService(NOTIFICATION_SERVICE);

        int id = getResources().getInteger(R.integer.NOTIFICATION_ID);
        manager.notify(id, no);
    }

    private class Worker extends Thread {

        private int perdidas = 0;

        private boolean ativo = true;
        private int startID;

        public Worker(int startID) {
            this.startID = startID;
        }

        @Override
        public void run() {
            while (true) {
                try {
                    Thread.sleep(3600000); // Aguarda uma hora e notifica o cliente para avaliar o produto
                    //Thread.sleep(1200000);
                    //Thread.sleep(5000);
                } catch (InterruptedException e) {
                    e.printStackTrace();
                }

                /* Verifica o laço deve continuar */
                if (!ativo || perdidas > 20)
                    break;

                Log.i("PEDIDO_SERVICE", "VERIFICADO");

                ServerRequest request = new ServerRequest(PedidoService.this, new ServerRequest.RequestListener() {
                    @Override
                    public void onResponseSuccess(ServerResponse response) {
                        if (response.getCode() == 200 && "OK".equals(response.getOutput())) {

                            // Notifica o usuário e exclui a flag de monitoramento do SharedPreferences
                            // para que não seja verificado um pedido que já foi concluido
                            SharedPreferences sp = getSharedPreferences("cliente", 0);
                            SharedPreferences.Editor editor = sp.edit();
                            editor.remove("monitorar");
                            editor.apply();

                            Log.i("PEDIDO_SERVICE", "NOTIFICADO");
                            notificar();

                            stopSelf(startID);
                        }
                    }

                    @Override
                    public void onResponseError(ServerResponse response) {
                        Log.e("PEDIDO_SERVICE", "REQUISICAO PERDIDA");
                        perdidas++;
                    }

                    @Override
                    public void onRequestError(ServerResponse response) {
                        Log.e("PEDIDO_SERVICE", "REQUISICAO PERDIDA");
                        perdidas++;
                    }
                });
                request.hasViews = false; // Diz para a classe que não existe interface, então não mostra janela de carregando
                request.send("/pedidos/" + codigo + "/verificar");
            }
            Log.i("PEDIDO_SERVICE", "CARA, AGORA O SERVICO PAROU DE VEZ :(");
            stopSelf(startID);
        }
    }
}
