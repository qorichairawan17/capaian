CREATE TABLE IF NOT EXISTS `iku_targets` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `iku_code` VARCHAR(10) NOT NULL COMMENT 'Kode IKU, misal: 1.1, 1.2, ..., 1.11',
    `tahun` YEAR NOT NULL COMMENT 'Tahun anggaran',
    `periode_type` ENUM('bulanan','triwulan','semester','tahunan') NOT NULL COMMENT 'Jenis periode',
    `periode_value` TINYINT(2) UNSIGNED NOT NULL COMMENT 'Nilai periode: 1-12 (bulanan), 1-4 (triwulan), 1-2 (semester), 1 (tahunan)',
    `target_value` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Nilai target (persentase)',
    `created_by` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'ID user pembuat',
    `updated_by` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'ID user pengubah terakhir',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_iku_target` (`iku_code`, `tahun`, `periode_type`, `periode_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci COMMENT='Tabel penyimpanan target per IKU per periode';
