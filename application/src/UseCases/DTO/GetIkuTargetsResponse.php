<?php
namespace App\UseCases\DTO;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * GetIkuTargetsResponse DTO
 *
 * Data keluar berisi daftar target IKU beserta metadata.
 */
class GetIkuTargetsResponse
{
    private $targets;
    private $ikuCode;
    private $tahun;
    private $periodeType;

    /**
     * @param \App\Domain\Entities\IkuTarget[] $targets
     * @param string $ikuCode
     * @param int    $tahun
     * @param string $periodeType
     */
    public function __construct(array $targets, $ikuCode, $tahun, $periodeType)
    {
        $this->targets = $targets;
        $this->ikuCode = $ikuCode;
        $this->tahun = (int) $tahun;
        $this->periodeType = $periodeType;
    }

    /** @return \App\Domain\Entities\IkuTarget[] */
    public function getTargets() { return $this->targets; }
    public function getIkuCode() { return $this->ikuCode; }
    public function getTahun() { return $this->tahun; }
    public function getPeriodeType() { return $this->periodeType; }

    /**
     * Convert targets to associative array keyed by periode_value.
     *
     * @return array [periodeValue => targetValue, ...]
     */
    public function toMap()
    {
        $map = [];
        foreach ($this->targets as $target) {
            $map[$target->getPeriodeValue()] = $target->getTargetValue();
        }
        return $map;
    }
}
