package com.edvaldotsi.fastfood.validator;

import com.rengwuxian.materialedittext.validation.RegexpValidator;

/**
 * Created by Edvaldo on 19/09/2015.
 */
public class EmailValidator extends RegexpValidator {

    public EmailValidator(String errorMessage) {
        super(errorMessage, "\\w+@\\w+\\.\\w{2,3}(\\.[a-zA-Z]{2})?");
    }
}
