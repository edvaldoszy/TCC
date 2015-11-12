package com.edvaldotsi.fastfood.validator;

import android.support.annotation.NonNull;

import com.rengwuxian.materialedittext.validation.RegexpValidator;

/**
 * Created by Edvaldo on 19/09/2015.
 */
public class EmptyValidator extends RegexpValidator {

    public EmptyValidator(String errorMessage) {
        super(errorMessage, "");
    }

    @Override
    public boolean isValid(@NonNull CharSequence text, boolean isEmpty) {
        return text.length() > 0;
    }
}
