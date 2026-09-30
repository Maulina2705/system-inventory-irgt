-- ==========================================================
-- SQL UPDATE SCRIPT FOR CPANEL (phpMyAdmin)
-- Sistem Inventaris IRGT School
-- Fitur: Creator Tracking, Solver Tracking & Asset History Log
-- ==========================================================

-- 1. Tambah kolom Creator & Solver ke tabel `assets`
ALTER TABLE `assets`
  ADD COLUMN `created_by_user_id` BIGINT UNSIGNED NULL AFTER `notes`,
  ADD COLUMN `last_updated_by_user_id` BIGINT UNSIGNED NULL AFTER `created_by_user_id`,
  ADD COLUMN `last_solved_by_user_id` BIGINT UNSIGNED NULL AFTER `last_updated_by_user_id`,
  ADD COLUMN `last_solved_at` TIMESTAMP NULL AFTER `last_solved_by_user_id`;

-- Tambahkan Foreign Keys ke tabel `users`
ALTER TABLE `assets`
  ADD CONSTRAINT `fk_assets_created_by` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assets_updated_by` FOREIGN KEY (`last_updated_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assets_solved_by` FOREIGN KEY (`last_solved_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

-- 2. Buat tabel `asset_histories` untuk mencatat log riwayat aset
CREATE TABLE IF NOT EXISTS `asset_histories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` BIGINT UNSIGNED NOT NULL,
  `user_id` BIGINT UNSIGNED NULL,
  `action` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_status` VARCHAR(30) COLLATE utf8mb4_unicode_ci NULL,
  `new_status` VARCHAR(30) COLLATE utf8mb4_unicode_ci NULL,
  `notes` TEXT COLLATE utf8mb4_unicode_ci NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_histories_asset_id` (`asset_id`),
  KEY `idx_histories_user_id` (`user_id`),
  KEY `idx_histories_action` (`action`),
  CONSTRAINT `fk_histories_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_histories_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
