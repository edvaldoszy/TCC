package com.edvaldotsi.fastfood.dao;

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

    }
}
