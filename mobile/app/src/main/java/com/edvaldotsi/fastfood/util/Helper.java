package com.edvaldotsi.fastfood.util;

import android.content.Context;

import com.edvaldotsi.fastfood.R;

import java.text.DecimalFormat;

/**
 * Created by Edvaldo on 09/11/2015.
 */
public class Helper {

    public static String loadImage(Context context, String path) {

        return context.getResources().getString(R.string.server_host) + path;
    }

    public static String formatNumber(float valor) {
        DecimalFormat df = new DecimalFormat("0.00");
        return df.format(valor);
    }
}
