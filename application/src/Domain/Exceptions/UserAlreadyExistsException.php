<?php
namespace App\Domain\Exceptions;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserAlreadyExistsException extends \RuntimeException
{
    public function __construct($message = 'Username sudah digunakan', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
