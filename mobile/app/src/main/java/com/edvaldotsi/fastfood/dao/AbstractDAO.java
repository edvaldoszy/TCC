package com.edvaldotsi.fastfood.dao;

import android.content.Context;
import android.content.res.Resources;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import com.edvaldotsi.fastfood.R;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Edvaldo on 14/09/2015.
 */
public abstract class AbstractDAO<O> extends SQLiteOpenHelper {

    protected String table = "";

    private Resources res;

    private static final String DB_NAME = "fast_food";
    private static final int DB_VERSION = 1;

    public AbstractDAO(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
        res = context.getResources();
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(res.getString(R.string.SQL_CREATE_TABLE_CLIENTE));
        db.execSQL(res.getString(R.string.SQL_CREATE_TABLE_CIDADE));
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    protected boolean parseBoolean(int value) {
        return value > 0;
    }

    protected abstract O createObject(Cursor c);

    public abstract void insert(O model);

    public List<O> select(String[] columns, String where, String[] arguments) {
        Cursor c = getReadableDatabase().query(table, columns, where, arguments, null, null, null);

        List<O> list = new ArrayList<>();
        while (c.moveToNext())
            list.add(createObject(c));

        return list;
    }
}
