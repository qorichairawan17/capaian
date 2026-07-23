<?php
namespace App\Domain\Repositories;

defined('BASEPATH') OR exit('No direct script access allowed');

interface CaseIku16RepositoryInterface
{
    /**
     * Find all IKU 1.6 execution application records based on filters.
     *
     * @param array $filters Supported keys: 'status_eksekusi', 'periode'
     * @return \App\Domain\Entities\CaseIku16Record[]
     */
    public function findAll(array $filters);
}
