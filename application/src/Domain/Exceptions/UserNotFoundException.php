<?php
namespace App\Domain\Exceptions;

defined('BASEPATH') OR exit('No direct script access allowed');

class UserNotFoundException extends \RuntimeException
{
    public function __construct($message = 'Pengguna tidak ditemukan', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
