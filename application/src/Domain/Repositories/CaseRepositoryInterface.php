<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseRepositoryInterface
{
    /**
     * Find all cases with given filters
     *
     * @param array $filters
     * @return \App\Domain\Entities\CaseRecord[]
     */
    public function findAll(array $filters);
}
