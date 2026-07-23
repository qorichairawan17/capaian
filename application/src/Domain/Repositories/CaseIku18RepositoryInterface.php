<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku18Record;

interface CaseIku18RepositoryInterface
{
    /**
     * Find all cases for IKU 1.8 with given filters
     *
     * @param array $filters
     * @return CaseIku18Record[]
     */
    public function findAll(array $filters);
}
