package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;

import java.util.List;

/**
 * Created by Edvaldo on 28/08/2015.
 */
public abstract class AbstractAdapter<T> extends ArrayAdapter<T> {

    private LayoutInflater inflater;
    private int resource;

    public AbstractAdapter(Context context, int resource, List<T> objects) {
        super(context, resource, objects);
        this.resource = resource;
        this.inflater = (LayoutInflater) getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    @Override
    public View getView(int position, View view, ViewGroup parent) {
        if (view == null)
            view = inflater.inflate(resource, parent, false);

        return customView(position, view, parent, getItem(position));
    }

    public abstract View customView(int position, View view, ViewGroup parent, T item);
}
