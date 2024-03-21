<?php
class systemException extends Exception
{
    private $input;
    public function __construct(string $message, int $code, ?string $input, $previous = null)
    {
        $this->input = $input;
        parent::__construct($message, $code, $previous);
    }
    final public function getInput()
    {
        return $this->input;
    }
}