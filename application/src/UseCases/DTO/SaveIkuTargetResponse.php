<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SaveIkuTargetResponse DTO
 *
 * Data keluar setelah menyimpan target IKU.
 */
class SaveIkuTargetResponse
{
    private $success;
    private $message;
    private $savedCount;

    public function __construct($success, $message, $savedCount = 0)
    {
        $this->success = (bool) $success;
        $this->message = $message;
        $this->savedCount = (int) $savedCount;
    }

    public function isSuccess() { return $this->success; }
    public function getMessage() { return $this->message; }
    public function getSavedCount() { return $this->savedCount; }
}
