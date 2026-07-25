<?php
namespace App\Domain\Exceptions;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * InvalidTargetException
 *
 * Dilempar saat validasi bisnis target gagal
 * (misal: nilai negatif, kode IKU tidak valid, periode di luar range).
 */
class InvalidTargetException extends \RuntimeException
{
}
