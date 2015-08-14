<?php

namespace Szy\Validation;

class Validator implements Validation
{
    /**
     * @var mixed $value
     */
    protected $value;

    /**
     * @param mixed $v
     * @return $this
     */
    public function value($v)
    {
        $this->value = $v;
        return $this;
    }

    /**
     * @param mixed $value
     * @param string $message
     * @return $this
     * @throws Exception\ValidationException
     */
    public function equals($value, $message)
    {
        if ($this->value != $value)
            throw new Exception\ValidationException($message);

        return $this;
    }

    /**
     * @param string $message
     * @return $this
     * @throws Exception\ValidationException
     */
    public function valid($message)
    {
        $value = trim($this->value);
        if (empty($value))
            throw new Exception\ValidationException($message);

        return $this;
    }

    /**
     * @param string $filter
     * @param string $message
     * @return $this
     * @throws Exception\ValidationException
     */
    public function filter($filter, $message)
    {
        if (!preg_match($filter, $this->value))
            throw new Exception\ValidationException($message);

        return $this;
    }

    /**
     * @return $this
     * @throws Exception\ValidationException
     */
    public function email()
    {
        if (!preg_match(self::FILTER_EMAIL, $this->value))
            throw new Exception\ValidationException("Endereço de e-mail inválido");

        return $this;
    }

    /**
     * @return $this
     * @throws Exception\ValidationException
     */
    public function fone()
    {
        if (!preg_match(self::FILTER_FONE, $this->value))
            throw new Exception\ValidationException("Número de telefone inválido");

        return $this;
    }
}