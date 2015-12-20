package com.edvaldotsi.fastfood.dao;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.ProdutoItem;

import java.util.List;

/**
 * Created by Edvaldo on 05/11/2015.
 */
public class ProdutoItemDAO extends AbstractDAO<ProdutoItem> {

    public ProdutoItemDAO(Context context) {
        super(context);
    }

    @Override
    protected ProdutoItem createObject(Cursor c) {
        return null;
    }

    @Override
    public void insert(ProdutoItem model) {

        ContentValues cv = new ContentValues();

        long codigo = getWritableDatabase().insert("produto", null, cv);
        model.setCodigo((int) codigo);
    }
}
