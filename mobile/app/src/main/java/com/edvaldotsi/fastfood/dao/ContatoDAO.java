package com.edvaldotsi.fastfood.dao;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.Contato;

/**
 * Created by Edvaldo on 22/09/2015.
 */
public class ContatoDAO extends AbstractDAO<Contato> {

    public ContatoDAO(Context context) {
        super(context);
    }

    @Override
    protected Contato createObject(Cursor c) {
        return null;
    }

    @Override
    public void insert(Contato contato) {
        ContentValues cv = new ContentValues();
        cv.put("telefone", contato.getTelefone());
        //cv.put("cliente", contato.getCliente().getCodigo());

        long codigo = getWritableDatabase().insert("contato", null, cv);
        contato.setCodigo((int) codigo);
    }
}
