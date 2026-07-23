<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseIku15RepositoryInterface
{
    /**
     * Find all IKU 1.5 e-Berpadu criminal appeal case records with given filters
     *
     * @param array $filters
     * @return \App\Domain\Entities\CaseIku15Record[]
     */
    public function findAll(array $filters);
}
