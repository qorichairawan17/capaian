<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseIku14RepositoryInterface
{
    /**
     * Find all IKU 1.4 e-Court appeal case records with given filters
     *
     * @param array $filters
     * @return \App\Domain\Entities\CaseIku14Record[]
     */
    public function findAll(array $filters);
}
