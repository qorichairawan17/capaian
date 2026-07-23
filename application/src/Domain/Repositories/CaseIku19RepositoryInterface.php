<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku19Record;

interface CaseIku19RepositoryInterface
{
    /**
     * @param array $filters  Array filter misal ['periode' => 't1', 'status_diversi' => 'berhasil']
     * @return CaseIku19Record[]
     */
    public function findAll(array $filters);
}
