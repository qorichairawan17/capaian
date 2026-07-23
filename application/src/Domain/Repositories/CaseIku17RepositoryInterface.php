<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

use App\Domain\Entities\CaseIku17Record;

interface CaseIku17RepositoryInterface
{
    /**
     * Find all cases for IKU 1.7 with given filters
     *
     * @param array $filters
     * @return CaseIku17Record[]
     */
    public function findAll(array $filters);
}
