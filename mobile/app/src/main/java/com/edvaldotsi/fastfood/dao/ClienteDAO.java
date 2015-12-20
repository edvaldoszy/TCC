package com.edvaldotsi.fastfood.dao;

import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.Cliente;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

/**
 * Created by Edvaldo on 14/09/2015.
 */
public class ClienteDAO extends AbstractDAO<Cliente> {

    public ClienteDAO(Context context) {
        super(context);
    }

    @Override
    protected Cliente createObject(Cursor c) {
        Cliente cliente = new Cliente();
        cliente.setCodigo(c.getInt(c.getColumnIndex("codigo")));
        cliente.setNome(c.getString(c.getColumnIndex("nome")));
        cliente.setEmail(c.getString(c.getColumnIndex("email")));
        cliente.setSenha(c.getString(c.getColumnIndex("senha")));
        cliente.setAdmin(parseBoolean(c.getInt(c.getColumnIndex("admin"))));

        return cliente;
    }

    @Override
    public void insert(Cliente model) {

    }
}
