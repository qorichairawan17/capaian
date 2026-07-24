<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku110Record;

interface CaseIku110RepositoryInterface
{
    /**
     * @param array $filters  Array filter misal ['periode' => 't1', 'metode' => 'ecourt']
     * @return CaseIku110Record[]
     */
    public function findAll(array $filters);
}
