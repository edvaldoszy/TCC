<?php

namespace Szy\Validation;

interface Validation
{
    /**
     * Empty filter
     */
    const FILTER_EMPTY = '/[0-9a-zA-Z]+/';

    /**
     * Phone filter
     * (##) ####-####
     */
    const FILTER_FONE = '/^\([0-9]{2}\)\s?[0-9]{4}\-[0-9]{4,5}/';

    /**
     * E-mail filter
     * address@provider.com
     */
    const FILTER_EMAIL = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/i';
}