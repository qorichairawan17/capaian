<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseIku13RepositoryInterface
{
    /**
     * Find all IKU 1.3 directory upload case records with given filters
     *
     * @param array $filters
     * @return \App\Domain\Entities\CaseIku13Record[]
     */
    public function findAll(array $filters);
}
