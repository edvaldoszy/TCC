package com.edvaldotsi.fastfood.util;

import android.content.Context;
import android.content.DialogInterface;
import android.support.v7.app.AlertDialog;

/**
 * Created by Edvaldo on 23/10/2015.
 */
public class ConfirmDialog {

    private AlertDialog dialog;

    public ConfirmDialog(Context context, String title, String message) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setTitle(title);
        builder.setMessage(message);
        builder.setPositiveButton("Sim", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                onPositiveButtonClick(dialog, which);
            }
        });
        builder.setNegativeButton("Não", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                onNegativeButtonClick(dialog, which);
            }
        });
        dialog = builder.create();
    }

    public void onPositiveButtonClick(DialogInterface dialog, int which) {

    }

    public void onNegativeButtonClick(DialogInterface dialog, int which) {
        dismiss();
    }

    public void show() {
        dialog.show();
    }

    public void dismiss() {
        dialog.dismiss();
    }
}
