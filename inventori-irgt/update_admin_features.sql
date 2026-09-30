-- SQL Script untuk update fitur Super Admin (Reset Password Default & Show Password)
-- Jalankan di phpMyAdmin cPanel jika diperlukan

ALTER TABLE `users` ADD COLUMN `plain_password` VARCHAR(255) NULL AFTER `password`;
