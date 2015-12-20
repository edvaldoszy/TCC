package com.edvaldotsi.fastfood.dao;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.Produto;

/**
 * Created by Edvaldo on 05/11/2015.
 */
public class ProdutoDAO extends AbstractDAO<Produto> {

    public ProdutoDAO(Context context) {
        super(context);
    }

    @Override
    protected Produto createObject(Cursor c) {
        return null;
    }

    @Override
    public void insert(Produto model) {
        ContentValues cv = new ContentValues();

        long codigo = getWritableDatabase().insert("produto", null, cv);
        model.setCodigo((int) codigo);
    }
}
