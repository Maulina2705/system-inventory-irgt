-- ==========================================================
-- SQL UPDATE SCRIPT FOR CPANEL (phpMyAdmin)
-- Sistem Inventaris IRGT School
-- Fitur: Laporan Maintenance / Pengajuan Servis User & Petugas IT
-- ==========================================================

CREATE TABLE IF NOT EXISTS `maintenance_reports` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `report_number` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `reporter_name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reporter_phone` VARCHAR(50) COLLATE utf8mb4_unicode_ci NULL,
  `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` ENUM('LOW','MEDIUM','HIGH','EMERGENCY') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MEDIUM',
  `photo_path` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
  `status` ENUM('PENDING','IN_PROGRESS','RESOLVED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `handled_by_user_id` BIGINT UNSIGNED NULL,
  `technician_notes` TEXT COLLATE utf8mb4_unicode_ci NULL,
  `resolved_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_reports_number` (`report_number`),
  KEY `idx_reports_asset_id` (`asset_id`),
  KEY `idx_reports_user_id` (`user_id`),
  KEY `idx_reports_status` (`status`),
  KEY `idx_reports_priority` (`priority`),
  KEY `idx_reports_handled_by` (`handled_by_user_id`),
  CONSTRAINT `fk_reports_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reports_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reports_handler` FOREIGN KEY (`handled_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
