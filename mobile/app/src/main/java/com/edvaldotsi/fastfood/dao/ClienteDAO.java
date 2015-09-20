package com.edvaldotsi.fastfood.dao;

import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.Cliente;

/**
 * Created by Edvaldo on 14/09/2015.
 */
public class ClienteDAO extends AbstractDAO<Cliente> {

    public ClienteDAO(Context context) {
        super(context);
    }

    @Override
    public void insert(Cliente model) {

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

    public Cliente getUsuarioLogado(boolean visitante) {
        if (visitante)
            return new Cliente(0, "Visitante");

        return createObject(getReadableDatabase().query("cliente", null, null, null, null, null, null));
    }
}
