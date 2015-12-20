package com.edvaldotsi.fastfood.adapter;

import android.content.Context;
import android.content.res.TypedArray;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Generic Adapter
 * 
 * Created by Douglas on 25/08/15.
 */
public abstract class AbstractAdapter<VH extends AbstractAdapter.AbstractViewHolder, I> extends RecyclerView.Adapter<VH> {

    protected final Context mContext;
    protected List<I> mItems;
    protected final LayoutInflater mLayoutInflater;

    public AbstractAdapter(Context context) {
        this(context, new ArrayList<I>());
    }

    public AbstractAdapter(Context context, List<I> items) {
        mContext = context;
        mItems = items;
        mLayoutInflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    }

    protected View inflate(int resource, ViewGroup root, boolean attach) {
        return mLayoutInflater.inflate(resource, root, attach);
    }

    @Override
    public void onBindViewHolder(final VH holder, final int position) {
        if (position >= 0 && position < mItems.size()) {
            final I item = mItems.get(position);
            onBindViewHolder(holder, position, item);
        }
    }

    protected abstract void onBindViewHolder(VH holder, int position, I item);

    @Override
    public int getItemCount() {
        return mItems.size();
    }

    public void setItems(List<I> items) {
        mItems = items;
    }

    public void setItems(I[] items) {
        mItems = Arrays.asList(items);
    }

    public List<I> getItems() {
        return mItems;
    }

    public I getItem(int position) {
        return mItems.get(position);
    }

    protected void onItemClickListener(int adapterPosition, int layoutPosition) {

    }

    protected boolean onLongItemClickListener(int adapterPosition, int layoutPosition) {
        return false;
    }

    public class AbstractViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener, View.OnLongClickListener {

        public AbstractViewHolder(View v) {
            super(v);
            v.setClickable(true);
            v.setOnClickListener(this);
            v.setOnLongClickListener(this);
            if (v instanceof FrameLayout) {
                int[] textSizeAttr = new int[]{android.R.attr.selectableItemBackground};
                int indexOfAttr = 0;
                TypedArray a = mContext.obtainStyledAttributes(textSizeAttr);
                ((FrameLayout) v).setForeground(a.getDrawable(indexOfAttr));
                a.recycle();
            }
        }

        @Override
        public void onClick(View v) {
            onItemClickListener(getAdapterPosition(), getLayoutPosition());
        }

        @Override
        public boolean onLongClick(View v) {
            return onLongItemClickListener(getAdapterPosition(), getLayoutPosition());
        }
    }
}
