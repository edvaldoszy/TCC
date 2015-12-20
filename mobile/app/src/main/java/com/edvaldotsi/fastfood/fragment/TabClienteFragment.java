package com.edvaldotsi.fastfood.fragment;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.BitmapDrawable;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.Fragment;
import android.util.Base64;
import android.util.Log;
import android.view.ContextMenu;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.edvaldotsi.fastfood.ClienteActivity;
import com.edvaldotsi.fastfood.ContaActivity;
import com.edvaldotsi.fastfood.R;
import com.edvaldotsi.fastfood.dao.ContaDAO;
import com.edvaldotsi.fastfood.model.Cliente;
import com.edvaldotsi.fastfood.request.PostData;
import com.edvaldotsi.fastfood.request.ServerRequest;
import com.edvaldotsi.fastfood.request.ServerResponse;
import com.edvaldotsi.fastfood.util.CircleTransform;
import com.edvaldotsi.fastfood.util.Helper;
import com.squareup.picasso.Callback;
import com.squareup.picasso.Picasso;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

public class TabClienteFragment extends Fragment {

    private static final int FRAGMENT_GROUPID = 20;
    private static final int MENU_SELECIONAR = 1;
    private static final int MENU_TIRAR = 2;

    private static final int REQUEST_TIRAR_FOTO = 100;
    private static final int REQUEST_SELECIONAR_FOTO = 200;

    private Activity activity;
    private ImageView imgPerfil;
    private TextView tvNome, tvEmail;

    // Utilizado quando o usuário tira uma foto para enviar para o perfil
    private Uri imagemUri;

    public static TabClienteFragment newInstance() {
        return new TabClienteFragment();
    }

    public TabClienteFragment() {
        // Required empty public constructor
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setHasOptionsMenu(true);
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        super.onCreateOptionsMenu(menu, inflater);
        menu.getItem(0).setVisible(false);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        switch (item.getItemId()) {
            case R.id.mn_alterar:
                startActivity(new Intent(activity, ClienteActivity.class));
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_tab_cliente, container, false);

        imgPerfil = (ImageView) view.findViewById(R.id.img_perfil);
        registerForContextMenu(imgPerfil);
        imgPerfil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                activity.openContextMenu(v);
            }
        });
        tvNome = (TextView) view.findViewById(R.id.tv_nome);
        tvEmail = (TextView) view.findViewById(R.id.tv_email);

        update();
        return view;
    }

    @Override
    public void onAttach(Activity activity) {
        super.onAttach(activity);
        this.activity = activity;
    }

    @Override
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);
        menu.add(FRAGMENT_GROUPID, MENU_SELECIONAR, Menu.NONE, "Selecionar uma foto");
        menu.add(FRAGMENT_GROUPID, MENU_TIRAR, Menu.NONE, "Tirar uma foto");
        menu.add(FRAGMENT_GROUPID, 0, Menu.NONE, "Cancelar");
    }

    @Override
    public boolean onContextItemSelected(MenuItem item) {

        if (item.getGroupId() == FRAGMENT_GROUPID) {

            switch (item.getItemId()) {
                case MENU_SELECIONAR:
                    mudarFoto(REQUEST_SELECIONAR_FOTO);
                    break;

                case MENU_TIRAR:
                    mudarFoto(REQUEST_TIRAR_FOTO);
                    break;
            }
        }
        return super.onContextItemSelected(item);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent intent) {

        if (resultCode != Activity.RESULT_OK)
            return;

        try {
            if (requestCode == REQUEST_TIRAR_FOTO) {
                Bitmap bitmap = BitmapFactory.decodeFile(imagemUri.getPath());
                atualizaImagemPerfil(bitmap);
            } else if (requestCode == REQUEST_SELECIONAR_FOTO) {
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(activity.getContentResolver(), intent.getData());
                imagemUri = intent.getData();
                atualizaImagemPerfil(bitmap);
            }

            int width = (int) (140 * getResources().getDisplayMetrics().density);
            int height = (int) (140 * getResources().getDisplayMetrics().density);
            Picasso.with(activity).load(imagemUri).error(R.drawable.cliente_sem_imagem).resize(width, height).centerCrop().transform(new CircleTransform()).into(imgPerfil);
        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    private void atualizaImagemPerfil(Bitmap bitmap) {

        ByteArrayOutputStream stream = new ByteArrayOutputStream();
        bitmap.compress(Bitmap.CompressFormat.JPEG, 80, stream);

        PostData data = new PostData();
        data.put("codigo", ContaDAO.getCliente().getCodigo());
        data.put("imagem", Base64.encodeToString(stream.toByteArray(), Base64.DEFAULT));

        // Faz a requisição e envia a imagem selecionada para o servidor
        ServerRequest request = new ServerRequest(activity, new ServerRequest.RequestListener() {
            @Override
            public void onResponseSuccess(ServerResponse response) {
                if (response.getCode() == 200)
                    ((ContaActivity) activity).showMessage("Imagem de perfil atualizada");
            }

            @Override
            public void onResponseError(ServerResponse response) {
                ((ContaActivity) activity).onResponseError(response);
            }

            @Override
            public void onRequestError(ServerResponse response) {
                ((ContaActivity) activity).onRequestError(response);
            }
        }, ServerRequest.METHOD_POST);
        request.send("/clientes/imagem", data);
    }

    private void update() {
        Cliente cliente = ContaDAO.getCliente();

        tvNome.setText(cliente.getNome());
        tvEmail.setText(cliente.getEmail());

        int width = (int) (140 * getResources().getDisplayMetrics().density);
        int height = (int) (140 * getResources().getDisplayMetrics().density);

        String imagem = Helper.loadImage(activity, cliente.getImagem(), 140, 140);
        Picasso.with(activity).load(imagem).resize(width, height).transform(new CircleTransform()).into(imgPerfil);
    }

    private void mudarFoto(int code) {

        Intent intent;
        switch (code) {
            case REQUEST_TIRAR_FOTO:
                intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                imagemUri = Uri.fromFile(getOutputMediaFile());
                intent.putExtra(MediaStore.EXTRA_OUTPUT, imagemUri);
                startActivityForResult(intent, code);
                break;

            case REQUEST_SELECIONAR_FOTO:
                intent = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                startActivityForResult(intent, code);
                break;
        }
    }

    private File getOutputMediaFile() {

        File mediaStorage = new File(Environment.getExternalStoragePublicDirectory(Environment.DIRECTORY_DCIM), "BocaSanta");

        if (!mediaStorage.exists()) {
            if (!mediaStorage.mkdirs()) {
                Log.e("--- CAMERA ---", "Falha ao criar os diretórios");
                return null;
            }
        }

        String timeStamp = new SimpleDateFormat("yyyy-MM-dd_HH-mm-ss", Locale.US).format(new Date());
        return new File(mediaStorage.getAbsolutePath() + File.separator + "IMG_" + timeStamp + ".jpg");
    }
}
