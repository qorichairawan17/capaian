<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseIku12RepositoryInterface
{
    /**
     * Find all IKU 1.2 case delivery records with given filters
     *
     * @param array $filters
     * @return \App\Domain\Entities\CaseIku12Record[]
     */
    public function findAll(array $filters);
}
