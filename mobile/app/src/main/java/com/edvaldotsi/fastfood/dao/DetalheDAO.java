package com.edvaldotsi.fastfood.dao;

import android.content.Context;
import android.database.Cursor;

import com.edvaldotsi.fastfood.model.Detalhes;
import com.edvaldotsi.fastfood.model.Produto;
import com.edvaldotsi.fastfood.model.ProdutoItem;

/**
 * Created by Edvaldo on 07/12/2015.
 */
public class DetalheDAO extends AbstractDAO<Detalhes> {

    public DetalheDAO(Context context) {
        super(context);
    }

    @Override
    protected Detalhes createObject(Cursor c) {
        return null;
    }

    @Override
    public void insert(Detalhes model) {
        Produto p = model.getProduto();

        ProdutoDAO produtoDAO = new ProdutoDAO(mContext);
        produtoDAO.insert(p);

        ProdutoItemDAO dao = new ProdutoItemDAO(mContext);
        for (ProdutoItem pi : model.getItens()) {
            dao.insert(pi);
        }
    }
}
