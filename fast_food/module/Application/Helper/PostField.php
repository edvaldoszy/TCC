<?php

namespace Application\Helper;

class PostField
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $validators = array();

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->value = filter_input(INPUT_POST, $name);
    }

    /**
     * @param RegexValidator $validator
     * @return void
     */
    public function addValidator(RegexValidator $validator)
    {
        $this->validators[] = $validator;
    }

    /**
     * @param bool $exception
     * @return bool
     * @throws RegexValidatorException
     */
    public function validate($exception = true)
    {
        if (count($this->validators) < 1)
            return true;

        /** @var RegexValidator $validator */
        foreach ($this->validators as $validator) {
            $valid = $validator->valid($this->value);
            if (!$valid) {
                if ($exception)
                    throw new RegexValidatorException($validator->getMessage());

                return false;
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return strval($this->value);
    }
}