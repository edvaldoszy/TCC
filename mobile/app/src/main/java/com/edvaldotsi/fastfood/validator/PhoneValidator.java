package com.edvaldotsi.fastfood.validator;

import com.rengwuxian.materialedittext.validation.RegexpValidator;

/**
 * Created by Edvaldo on 22/09/2015.
 */
public class PhoneValidator extends RegexpValidator {

    public PhoneValidator(String errorMessage) {
        super(errorMessage, "\\(\\d{2,3}\\)\\s?\\d{4,5}\\-\\d{4}");
    }
}
