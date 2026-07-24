<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku111Record;

interface CaseIku111RepositoryInterface
{
    /**
     * @param array $filters  Array filter misal ['periode' => 't1', 'metode' => 'eberpadu']
     * @return CaseIku111Record[]
     */
    public function findAll(array $filters);
}
