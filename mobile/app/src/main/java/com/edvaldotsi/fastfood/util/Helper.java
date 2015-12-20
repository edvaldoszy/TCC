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

    public static String loadImage(Context context, String path, int width, int height) {

        return loadImage(context, path) + "?w=" + width + "&h=" + height;
    }

    public static String formatNumber(float valor) {
        DecimalFormat df = new DecimalFormat("0.00");
        return df.format(valor);
    }

    public static String formatNumber(float valor, String prefix) {
        return prefix + formatNumber(valor);
    }
}
