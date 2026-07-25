<?php
namespace App\Domain\Entities;

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * IkuTarget Entity
 *
 * Merepresentasikan satu record target IKU untuk periode tertentu.
 * PHP murni — tanpa dependency CI3.
 */
class IkuTarget
{
    private $id;
    private $ikuCode;
    private $tahun;
    private $periodeType;  // 'bulanan' | 'triwulan' | 'semester' | 'tahunan'
    private $periodeValue; // 1-12 (bulanan), 1-4 (triwulan), 1-2 (semester), 1 (tahunan)
    private $targetValue;
    private $createdBy;
    private $updatedBy;
    private $createdAt;
    private $updatedAt;

    /** @var array Periode types yang valid beserta range nilainya */
    private static $validPeriodeRanges = [
        'bulanan'  => ['min' => 1, 'max' => 12],
        'triwulan' => ['min' => 1, 'max' => 4],
        'semester' => ['min' => 1, 'max' => 2],
        'tahunan'  => ['min' => 1, 'max' => 1],
    ];

    /** @var array Kode IKU yang valid (kecuali 1.12) */
    private static $validIkuCodes = [
        '1.1', '1.2', '1.3', '1.4', '1.5',
        '1.6', '1.7', '1.8', '1.9', '1.10', '1.11'
    ];

    public function __construct(
        $id,
        $ikuCode,
        $tahun,
        $periodeType,
        $periodeValue,
        $targetValue,
        $createdBy = null,
        $updatedBy = null,
        $createdAt = null,
        $updatedAt = null
    ) {
        $this->id = $id;
        $this->ikuCode = $ikuCode;
        $this->tahun = (int) $tahun;
        $this->periodeType = $periodeType;
        $this->periodeValue = (int) $periodeValue;
        $this->targetValue = (float) $targetValue;
        $this->createdBy = $createdBy;
        $this->updatedBy = $updatedBy;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // ─── Getters ──────────────────────────────────────────────────────

    public function getId() { return $this->id; }
    public function getIkuCode() { return $this->ikuCode; }
    public function getTahun() { return $this->tahun; }
    public function getPeriodeType() { return $this->periodeType; }
    public function getPeriodeValue() { return $this->periodeValue; }
    public function getTargetValue() { return $this->targetValue; }
    public function getCreatedBy() { return $this->createdBy; }
    public function getUpdatedBy() { return $this->updatedBy; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getUpdatedAt() { return $this->updatedAt; }

    // ─── Business Rules ───────────────────────────────────────────────

    /**
     * Validasi invariant bisnis entity.
     *
     * @throws \App\Domain\Exceptions\InvalidTargetException
     */
    public function validate()
    {
        if (!in_array($this->ikuCode, self::$validIkuCodes, true)) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                "Kode IKU '{$this->ikuCode}' tidak valid. IKU yang didukung: " . implode(', ', self::$validIkuCodes)
            );
        }

        if (!array_key_exists($this->periodeType, self::$validPeriodeRanges)) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                "Tipe periode '{$this->periodeType}' tidak valid. Gunakan: bulanan, triwulan, semester, atau tahunan."
            );
        }

        $range = self::$validPeriodeRanges[$this->periodeType];
        if ($this->periodeValue < $range['min'] || $this->periodeValue > $range['max']) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                "Nilai periode {$this->periodeValue} tidak valid untuk tipe '{$this->periodeType}'. Range: {$range['min']}-{$range['max']}."
            );
        }

        if ($this->targetValue < 0) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                'Nilai target tidak boleh negatif.'
            );
        }

        if ($this->tahun < 2020 || $this->tahun > 2100) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                "Tahun {$this->tahun} tidak valid. Range: 2020-2100."
            );
        }
    }

    /**
     * Update nilai target.
     *
     * @param float $newValue
     * @param int|null $updatedBy
     */
    public function updateTarget($newValue, $updatedBy = null)
    {
        if ($newValue < 0) {
            throw new \App\Domain\Exceptions\InvalidTargetException(
                'Nilai target tidak boleh negatif.'
            );
        }
        $this->targetValue = (float) $newValue;
        $this->updatedBy = $updatedBy;
    }

    /**
     * Daftar kode IKU yang valid.
     *
     * @return array
     */
    public static function getValidIkuCodes()
    {
        return self::$validIkuCodes;
    }

    /**
     * Daftar range periode yang valid.
     *
     * @return array
     */
    public static function getValidPeriodeRanges()
    {
        return self::$validPeriodeRanges;
    }
}
