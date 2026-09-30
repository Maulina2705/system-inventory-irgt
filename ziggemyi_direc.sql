-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Agu 2026 pada 11.48
-- Versi server: 11.4.13-MariaDB
-- Versi PHP: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `ziggemyi_direc`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_code` varchar(255) NOT NULL,
  `inventory_year` smallint(5) UNSIGNED NOT NULL,
  `sequence_number` int(10) UNSIGNED NOT NULL,
  `placement_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `asset_type_id` bigint(20) UNSIGNED NOT NULL,
  `asset_item_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `ownership` varchar(255) NOT NULL DEFAULT 'IRGT School',
  `assigned_to` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','MAINTENANCE','DAMAGED','LOST','RETIRED') NOT NULL DEFAULT 'ACTIVE',
  `condition` enum('GOOD','FAIR','POOR','DAMAGED') NOT NULL DEFAULT 'GOOD',
  `purchase_date` date DEFAULT NULL,
  `vendor` varchar(255) DEFAULT NULL,
  `warranty_expiry` date DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `qr_token` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_updated_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_solved_by_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `last_solved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id`, `asset_code`, `inventory_year`, `sequence_number`, `placement_id`, `location_id`, `asset_type_id`, `asset_item_id`, `name`, `brand`, `model`, `serial_number`, `ownership`, `assigned_to`, `status`, `condition`, `purchase_date`, `vendor`, `warranty_expiry`, `ip_address`, `mac_address`, `qr_token`, `notes`, `created_by_user_id`, `last_updated_by_user_id`, `last_solved_by_user_id`, `last_solved_at`, `created_at`, `updated_at`) VALUES
(3, 'INV-ITL1NEMN-2026-001', 2026, 1, 1, 1, 2, 7, 'KOM 1', 'ASUS', 'LX1200', 'SNA-7776SAUSA', 'IRGT School', 'Ilal', 'ACTIVE', 'GOOD', '2026-08-27', 'ASUS INDONESIA', '2026-08-29', '192.168.1.2', 'AA:883:JDUASAAS', 'xljLOyteEN1f3TwYPmFlZYmszwyvl27x', NULL, 1, 1, NULL, NULL, '2026-08-26 14:09:44', '2026-08-26 14:09:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_histories`
--

CREATE TABLE `asset_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `old_status` varchar(30) DEFAULT NULL,
  `new_status` varchar(30) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_histories`
--

INSERT INTO `asset_histories` (`id`, `asset_id`, `user_id`, `action`, `old_status`, `new_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'CREATED', NULL, 'ACTIVE', 'Aset pertama kali didaftarkan ke sistem oleh IT Super Admin', '2026-08-26 14:09:44', '2026-08-26 14:09:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_items`
--

CREATE TABLE `asset_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_items`
--

INSERT INTO `asset_items` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'PC', 'Komputer', NULL, NULL),
(2, 'KY', 'Keyboard', NULL, NULL),
(3, 'MO', 'Mouse', NULL, NULL),
(4, 'PR', 'Printer', NULL, NULL),
(5, 'PY', 'Proyektor', NULL, NULL),
(6, 'CC', 'CCTV', NULL, NULL),
(7, 'MN', 'Monitor', NULL, NULL),
(8, 'UP', 'UPS', NULL, NULL),
(9, 'SP', 'Speaker', NULL, NULL),
(10, 'MI', 'MIC', NULL, NULL),
(11, 'MX', 'Mixer', NULL, NULL),
(12, 'AC', 'Accessories', NULL, NULL),
(13, 'OT', 'Other', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_types`
--

CREATE TABLE `asset_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_types`
--

INSERT INTO `asset_types` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'AD', 'Administrasi', NULL, NULL),
(2, 'NE', 'Networking', NULL, NULL),
(3, 'ME', 'Media', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-25d923323ae3a0401e56763a25d81dab', 'i:2;', 1787784796),
('laravel-cache-25d923323ae3a0401e56763a25d81dab:timer', 'i:1787784796;', 1787784796),
('laravel-cache-26171bf3f1023cff354854d525b8cf42', 'i:2;', 1787789547),
('laravel-cache-26171bf3f1023cff354854d525b8cf42:timer', 'i:1787789547;', 1787789547),
('laravel-cache-304a33cecc638be1c8185540d94a8be5', 'i:1;', 1787802574),
('laravel-cache-304a33cecc638be1c8185540d94a8be5:timer', 'i:1787802574;', 1787802574),
('laravel-cache-45c9455db704192905949070f1189cf2', 'i:1;', 1787797571),
('laravel-cache-45c9455db704192905949070f1189cf2:timer', 'i:1787797571;', 1787797571),
('laravel-cache-7bdd397c919744b2a8d89a905ee6050d', 'i:1;', 1787769869),
('laravel-cache-7bdd397c919744b2a8d89a905ee6050d:timer', 'i:1787769869;', 1787769869),
('laravel-cache-mhilal044@gmail.com|180.252.252.237', 'i:1;', 1787797571),
('laravel-cache-mhilal044@gmail.com|180.252.252.237:timer', 'i:1787797571;', 1787797571);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `locations`
--

INSERT INTO `locations` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'L1', 'Lantai 1', NULL, NULL),
(2, 'L2', 'Lantai 2', NULL, NULL),
(3, 'L3', 'Lantai 3', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000000_create_passkeys_table', 1),
(5, '2025_08_14_170933_add_two_factor_columns_to_users_table', 1),
(6, '2026_08_25_162127_create_placements_table', 1),
(7, '2026_08_25_162222_create_locations_table', 1),
(8, '2026_08_25_162341_create_asset_types_table', 1),
(9, '2026_08_25_162414_create_asset_items_table', 1),
(10, '2026_08_25_162527_create_assets_table', 1),
(11, '2026_08_26_175231_add_role_to_users_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `passkeys`
--

CREATE TABLE `passkeys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `credential_id` varchar(255) NOT NULL,
  `credential` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`credential`)),
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `placements`
--

CREATE TABLE `placements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `placements`
--

INSERT INTO `placements` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'IT', 'Milik IT', NULL, NULL),
(2, 'PE', 'Milik Perpustakaan', NULL, NULL),
(3, 'AU', 'Milik Aula', NULL, NULL),
(4, 'LO', 'Milik Lobby', NULL, NULL),
(5, 'SM', 'Milik Kantor SMP', NULL, NULL),
(6, 'SD', 'Milik Kantor SD', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3E91HGtwzH6vlZHZzGPGXcIb8cOi0nKTDx8g8CQb', NULL, '182.253.249.73', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.5.2 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJzazZncjZpdm9YNllMTGFqQmYxWFpyUHFRZ0M3N0toa3Y0ZXhHVnZGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787805326),
('3IL7UFW8jsJG11UCC2u6QyN7Hz17e5jrYA7ifkll', NULL, '149.50.96.188', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJRQzFBZUo3WUFrN1dFUFNUMUh5T24zVmtJQWVsYTMyc1hnVVFKSk8wIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802646),
('3Qg360qEsGQhdo8SOU8pCR2gvp62ZM64yGBhaQFc', NULL, '103.196.9.139', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJRUjRHT0RIS2R6YXE4WHl5RHk5MnpEelJWZnhka1RnWlozdmlGdGhIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802499),
('4o33P98kN0dEnGoB3agxzRd6RBQj7VKUqqvobSSb', NULL, '87.58.197.202', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI3WTg1WElreGQ5dm84MFByVjg4VkRramhzYzhuQzlrQzh0RlVOODJTIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787802361),
('5SNKjQJrC6Tg5kgwQzleyevPgQptsL9AIRoKDMYD', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiJBREoyZTN1QkxCQm1VV1Y2enR0Rk9ocmZPbXoyNUs5RkwybkhKdVpLIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787804654),
('6dcwv0JJksgtoCSsS4nhTsfbu0ljVQpACWkp9j7j', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiI4SzREd290eEdSQ2dYanE2R0xtd01XeU5icUQ3R2VpOGJPMmpmUFZ1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787804654),
('6Jy8ohd6t0w7BWZKVm2t88w55stWVEql2SSyT8sb', NULL, '85.137.57.233', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJLNkJPWnU4QnFVeWxQTXVndE5lOWZHNjFyNkxHQmkzVzNkMUo2dHhjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787806018),
('8HXFBzAd7iDdeZTGd7faZT8e1oeKzIzk27Q29Vf6', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiIwNlBZODZLV2VNQjRDR25ja1NVWUFOdXhkQ0RHaW5ieVpEUlBiQ3dRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787804653),
('8Ib2HG1fxetgncsjicOiJ7UiRKy8N5T1pRHItvUr', NULL, '158.69.117.45', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJNd3JaZDNDNTVxVEdINjM3dDlSY0hTdVV5cnVlcllOZTh2bTZFaFJ2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvZm9yZ290LXBhc3N3b3JkIiwicm91dGUiOiJwYXNzd29yZC5yZXF1ZXN0In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802547),
('8m6VH6yzFN5QTGgPsKl8I9PNPHsoE6PxL2ADAC48', NULL, '85.137.57.233', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJkM2s4b0syM0RPWHp0YUdCRXMySHRCVHRiWlBGeFZrV0tENFhXajlCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787806030),
('ApVhmq3nnEJMv7KrCBQAikjI6k8GotY5TEFGpJYL', NULL, '103.196.9.139', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJMaExxM1l3SVdJSElUSHBHdEVndXRXVGs2V0Y5dWtnUHpLUVJhZjA2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802499),
('BMNmu0E9GP5BS0i5EZOXgUWlDnch8FsqxAFiRn2j', NULL, '104.164.173.78', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJwRk80bkxaR1dOSWxvZlFIZ0JsWG9rbUo5WU5TS21MZmNoODFpWDdNIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802319),
('BqHnoPr3rVpC6J2nE22x03ir1FErrMRuCu3S80xv', NULL, '85.137.57.233', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJuSFMzR1lqYWpVU2JwdFZEZGZWYTVaaVRGNHRxZTVJck5YR1ZZd2ZtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787806026),
('btgCX4Wic1Q9OoLk0yPDjftV3zR0N3zvE5xYu4NV', 1, '180.252.252.237', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI5WVEwMVpxVllmZk5tVDE4TlNpN2JQWjc1NVFBdVpOZmVva1p6TUhFIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvYXNzZXRzIiwicm91dGUiOiJhc3NldHMuaW5kZXgifX0=', 1787803692),
('by1TgLXVUMnPNYp1lqKzqYRj4KGj8t3iiFDZiX2O', NULL, '57.131.131.17', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.7.5 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJNNUx3YUhDd2FMdkU4OVZ5b09maXFmMlZXWnNMSGo3aEloT0R4SUVIIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787798221),
('cnu7QZ3xHWGDWynPn0sUUBpymTu92vzp3SSeQLV6', NULL, '195.88.211.20', '', 'eyJfdG9rZW4iOiJ2MURFYXptY1pOTXNxVk5DT1pjZ243T3ZXWUdTeTB2cHRLWFBmZkdsIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802769),
('cy6RqThYh5daR94Cwax9htYtaEHnNEeb9nNgeV7w', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiJIckdRYWZLZmkybmYzaDJQYUZPa0pUdmo5S0lnQW52YlFwT3cxVVB6IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787804656),
('GPlNzNofwKyevGUsyJi7ZES5svfDzMWWb5eIzsaj', NULL, '51.178.22.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJHWmxnQktsVkM0MkZ3VTF3eUN0THFrd2RTczFsclN3akNLSHhUQ1hoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802385),
('hKDrjrtELSWSWxUqvXcsOuBWhRmmFD1s607yhB91', NULL, '192.178.15.195', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiIwRjByUTdWWWVJY1lYVlV1VHRURmJ3dUs2OG9XMnJSRE1jQWRzTm1ZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcHVibGljLWFzc2V0cyIsInJvdXRlIjoicHVibGljLmFzc2V0cy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787797926),
('hkf40lWieyNE8z3gYdtMmBlDavzJVvkeAd1E4mxk', NULL, '91.231.89.68', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'eyJfdG9rZW4iOiJDWTc5N0t3cDloS2NVclpNYnBYY3FiSkNpQnZiWEhWdXdmN2cwRWhYIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787802928),
('hvvgO0hPkzycb24VqFB6DAzMGirveBrJPCJgIZfO', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiJub1RRRGtWTXM4NnNiM1FXRGx3bGVYcmwxblZJMmk2VXBpYlk0SmROIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787804652),
('IkqTuxqQTcstV8kQprX5BQNClKG3472O2l3TtgSU', NULL, '74.7.243.248', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.4; +https://openai.com/gptbot)', 'eyJfdG9rZW4iOiJqVzVOcUtZWDdvWFJiajRzaVNKRWpzOUQxQWpibjVlOUw5R0VZTkVKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcHVibGljLWFzc2V0cyIsInJvdXRlIjoicHVibGljLmFzc2V0cy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787804511),
('iksciBD5sdD2ecGnIz6dkPf7HloaZEink0WJDnuo', NULL, '91.231.89.170', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'eyJfdG9rZW4iOiJrdVhuS25uWUJRTk5yeVRkcW05c3ZSUzhBSFhrYlB3MWM4TTNjbm52IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802924),
('jhbyLaxh4DqBjUStldPN2G4tM1Ubd1vxr41MuAYg', NULL, '103.4.251.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJwZm05MjlsNzFZZElIeWZ5QnQxUHJiVmRxODJTRlhWSDFXTXFJV2dtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcmVnaXN0ZXIiLCJyb3V0ZSI6InJlZ2lzdGVyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802369),
('JWYPjtBdol7AK7qA4BDbqLfKJusrp2qtthIiht65', NULL, '64.233.173.195', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJjUTNxUXJtMjBrVldiTGw2UVUyemVPVVY3b1hXUkd0cU5GeGhDVXJBIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcHVibGljLWFzc2V0cyIsInJvdXRlIjoicHVibGljLmFzc2V0cy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787797924),
('KEija2ALaVY6uH9yp8qX9d6k5r8cgx2nHiaKA3jo', NULL, '192.178.15.196', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'eyJfdG9rZW4iOiJmZnNwcVhwV25VSTV1ZHZEU1pwRkpMcFNScGZrYzROV2FRMkhFaFIwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcHVibGljLWFzc2V0cyIsInJvdXRlIjoicHVibGljLmFzc2V0cy5pbmRleCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787797926),
('kF0f0NtIhrwnad8xmLge6DJVh4Ngo0B2FFuOfDc1', NULL, '51.178.22.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXc1dldUwyV3FudUFGZHZ5TnE3M0R3VmJHNG4yaGhSa2VDN1ZpNWhJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZCIsInJvdXRlIjoiaG9tZSJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19', 1787802376),
('lt6YX8NM32UCUPlAS5p5SuPARoKwm45whu1o6Ea7', NULL, '119.12.183.219', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJ0Ykd0eVlSRVhkOWh5M3BNcHR5YzQzY2pjNVl2WkIzM2xtYlNOQlNJIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802498),
('lTtHtZAlGWLFJiYhwlnHlwFv6zwTcwSRclMT0vWu', NULL, '195.88.211.20', '', 'eyJfdG9rZW4iOiI1VFFrTU96WlZzekdUM0M3Tm5pWmxLWjNnTWdqejBsa0N2OHByUms5IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802826),
('LUClKuqsqDNEJgFVv4Y7ulScBWlh7f4bFVSVBXl5', NULL, '85.137.57.233', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJYa3hsd3dmbHpITFZpS0t3VnU2Y2hYQXdGRWlNS29Ib0lyczNPbDdMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787806022),
('LV9LtEQuivyGAI6olUdgOXuCBejSIc4FOTrfgLJH', NULL, '34.122.147.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.6422.60 Safari/537.36 Edge/12.246', 'eyJfdG9rZW4iOiJnTWdLSGdKbjBsQ3F0VW9vdUpUemI3cjBZRE5qR2x5SkNzVmtLancwIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802967),
('M3hwjSujpM8YNGQhZMaQAobUCS363rvkM1LPTlvo', NULL, '34.116.177.216', 'Mozilla/5.0 (iPhone13,2; U; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1', 'eyJfdG9rZW4iOiJCM1ZWRk1YMFhURWNoWFJ6WEJYZUxXNk1tRllCOWY5dUlTVTB0WjlGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787803057),
('MvtTjPV8yiFrReSalu5ZT7LdS9KGFemQAW11gxu6', NULL, '5.133.214.187', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiIzOTZETkVWVnp2MzdPZzF4UDlKdE9OaXNIeW8wa29Sb2FxcWQ5QUpaIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787803047),
('MyDLipDV3Qm5P714M7OhSJiMLMsvSuvUX21VFJXJ', NULL, '85.137.57.233', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJMZGVpMjdLOFh4Wko2SkhBdVBsT1duMlNLWXlsQ2RZYlIxb2hQTnpPIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787806030),
('nrWCeoEVn0nwtI0bhWjbGcxHjWRYUE5mqBckPTWI', NULL, '52.230.100.152', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJVd2lGNVF4blozeWN3OUV2V3NNQWplVGtYR2dTS01MaU5PUDhKeVZXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802480),
('opaz18ZbODNb6h3CojNXSVrfudkZ0YsJT1yQ3kLB', NULL, '103.196.9.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIzNHVkRGxjT0NDWDZLR290UFFKRGh0Z0s2dXVLQXJpMFR6SDc3eDVUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802353),
('paHcgUGcnEm2BAvO7POzEemnDJsbT2jBkCvkm6Xc', NULL, '103.196.9.98', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJhRVVNSDFXMWJDYTZRcUFUSWdHMksySVpNSzZFZHhIT2tUeHdEZDB2IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802344),
('ppCdqz32vxcXQsJfi8NFYMFti7uZy42LdtP1zlG6', NULL, '91.196.152.231', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'eyJfdG9rZW4iOiIyc0ZVRG9pTnl3V2pxWGdjTGY2SW9FQnRHRDd6WjdkekFOeXJXR0syIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787803099),
('PRB4bhIw8ruXuNk6GWbewXbRpgsMxwOrymTxvNog', NULL, '91.196.152.89', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'eyJfdG9rZW4iOiI0WVhCZk9SSUI2RUR4VGtLbkt3VFZjYmpuUVRQS056UE1udkttcmE1IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787803104),
('R18dqtVoZMPXd0godJ6sM6Z56NSdpmOPgz4KgdZm', 1, '180.252.252.237', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Mobile Safari/537.36', 'eyJfdG9rZW4iOiJaVHF2NDBha2dENWNKbklaTzFYUUZTNTVveWs4RlpRa3FYdEZiakVUIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvYXNzZXRzIiwicm91dGUiOiJhc3NldHMuaW5kZXgifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1787800306),
('rVA3MHRDwMWaSrh7U7Dlx6vZFH2qwy7qduWz75o4', NULL, '192.165.45.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiJvN0N2ZGR0NW02aHVjdnBZSDZCR3NlM08wRGJjejVXWXFGSFM4Y2NMIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787803049),
('RWsJZmrR9DO7ZPCjTXr4nzARcZGwxWRuUQJULM7T', NULL, '51.178.22.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJobERSV2Ewa3BTRVYxM1VJd0tEUFp0TkUxa1ZPUzFOWWk4NnRzSWJHIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802378),
('Ss80roNPzH1mRH2SRtegeDHrn2Vok5BUraPgUG6H', NULL, '158.69.55.82', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJWQnFvQ2pvYmZ2S0VXRlRYR1ZLMnZVaUo2b1hlVlE4c2Vka3h1cjFoIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvZm9yZ290LXBhc3N3b3JkIiwicm91dGUiOiJwYXNzd29yZC5yZXF1ZXN0In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802788),
('SwcMSlaSDVGIQIf4ICIKBewhpSsE9U4TyyCBfsIF', NULL, '103.196.9.225', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJiclpBcWQ0enUwSmVhMEQzUEpDWmFLZlZyM0FWWG5nUUNNZnpJbjJjIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvcmVnaXN0ZXIiLCJyb3V0ZSI6InJlZ2lzdGVyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802371),
('tIeeYnflNhkKrRPcskUT85Dx4yqyyxdm10AOj54W', NULL, '103.196.9.98', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJScU9qaHVYYW9QT2l4dnJqMEN2cjJJSGVGSGlBVnZPakczcEFnQXh3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802323),
('TjKzWAC7ppOsz5z8N8VAodx5Fwhv8IuaGTK6PLPw', NULL, '87.58.197.202', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJNNDUxRlpyb2NKOXBDN1lrTlNQVEwxdERMc2Vna0pGaENlam1CR1V0IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802362),
('wdDrucGXsXremX2OKtQRcikRhU0Fc68jQE05iNUe', NULL, '182.253.249.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlR3VEMzNRMTBraExScGFTMVpsQmVZVXRTVU50c255MmNpNTBzMkJhIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787806004),
('X0o9KMEZLDGDim2t121130MNDu66dqnBX52OKMZh', NULL, '195.88.211.20', '', 'eyJfdG9rZW4iOiI4WGNQb3hmazZLbXNRb3pnWG5GOFpYakZBdmVLQXRLR0NjN0RCbW9mIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787803336),
('xamsmZSkshR0YehaztGOQOS6yvX4uMeIAFQWFygU', NULL, '103.196.9.139', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_3_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/144.0.7559.95 Mobile/15E148 Safari/604.1', 'eyJfdG9rZW4iOiJSVU1GS0FGdklyUXVpUFlVZzVqNW5FMHQ1SDFyeGtqMEUzU3dxaWEyIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787802498),
('XgHeNmsyBpvCJK3mhka5E8zCjZpAWeuvmQTD7fOR', NULL, '151.115.100.23', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.3', 'eyJfdG9rZW4iOiI3TjJLcUtuU0ZKTXZzeXZhTHlTaGJTbGMzUXZyc3NYRUNCQ3lkUGdpIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787804655),
('xue7J568SjYkPCl8Axiwu7HKWE5tLHGZDjdnB5U2', NULL, '34.122.147.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.6422.60 Safari/537.36 Edge/12.246', 'eyJfdG9rZW4iOiJKQ0p0cWxHWXR6VHhGZENMMW90dHA3V3NPOHgwZktIcWo1NkhrTmVsIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802987),
('xwPkXN0lDFDRZk96DrnAYubkMaNvlBFNsIM9Kcoz', NULL, '151.115.100.23', 'python-httpx/0.28.1', 'eyJfdG9rZW4iOiJRNTJldnhwSElNNEFPaTZOeGN3d2Ztd1NkbnFadU56cER6aktXNkRKIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787804649),
('YneXyVeqOEZ4SuTctYUcEpr8F9ocAlWkYdj5k0Cd', NULL, '36.50.157.21', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/30.0 Chrome/143.0.0.0 Mobile Safari/537.36', 'eyJfdG9rZW4iOiJ1Rk9uSWozNkhFRDkwMVpDWXZvNzJyUEtTUXVRQXR5SVl1R09oa0pRIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cHM6XC9cL3ppZ2dlLm15LmlkXC9hc3NldHNcLzNcL2VkaXQifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC96aWdnZS5teS5pZFwvbG9naW4iLCJyb3V0ZSI6ImxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1787797918),
('ypMdsDS8bGikwSTqBfqu61G8cCkVDliMOpBKrR0p', NULL, '51.178.22.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJNSzlXRm5UdG9pV0dUdjhvSzB5S0JmRGxRcEN6RE80NWc0VUJYWXlCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3ppZ2dlLm15LmlkXC9sb2dpbiIsInJvdXRlIjoibG9naW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==', 1787802390);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'IT HEAD', 'it@zigge.my.id', 'super_admin', NULL, '$2y$12$lGE.ggECAhTwwy85OcnQWOkiUaV9IYjLNEDbkSF/Gw2a4vmYE.QUu', NULL, NULL, NULL, 'Wb0IRg7YoTjH1Hh5W6CzusLrMbkyaJLRetFGzjkX0DSlfDOqhTkoP0k3zCkL', '2026-08-26 18:02:58', '2026-08-26 18:28:24');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_sequence_unique` (`placement_id`,`location_id`,`asset_type_id`,`asset_item_id`,`inventory_year`,`sequence_number`),
  ADD UNIQUE KEY `assets_asset_code_unique` (`asset_code`),
  ADD UNIQUE KEY `assets_qr_token_unique` (`qr_token`),
  ADD UNIQUE KEY `assets_serial_number_unique` (`serial_number`),
  ADD KEY `assets_location_id_foreign` (`location_id`),
  ADD KEY `assets_asset_type_id_foreign` (`asset_type_id`),
  ADD KEY `assets_asset_item_id_foreign` (`asset_item_id`),
  ADD KEY `assets_status_index` (`status`),
  ADD KEY `assets_condition_index` (`condition`),
  ADD KEY `assets_inventory_year_index` (`inventory_year`),
  ADD KEY `fk_assets_created_by` (`created_by_user_id`),
  ADD KEY `fk_assets_updated_by` (`last_updated_by_user_id`),
  ADD KEY `fk_assets_solved_by` (`last_solved_by_user_id`);

--
-- Indeks untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_histories_asset_id` (`asset_id`),
  ADD KEY `idx_histories_user_id` (`user_id`),
  ADD KEY `idx_histories_action` (`action`);

--
-- Indeks untuk tabel `asset_items`
--
ALTER TABLE `asset_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_items_code_unique` (`code`);

--
-- Indeks untuk tabel `asset_types`
--
ALTER TABLE `asset_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `asset_types_code_unique` (`code`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `locations_code_unique` (`code`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `passkeys`
--
ALTER TABLE `passkeys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `passkeys_credential_id_unique` (`credential_id`),
  ADD KEY `passkeys_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placements_code_unique` (`code`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assets`
--
ALTER TABLE `assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `asset_items`
--
ALTER TABLE `asset_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `asset_types`
--
ALTER TABLE `asset_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `passkeys`
--
ALTER TABLE `passkeys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `placements`
--
ALTER TABLE `placements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_asset_item_id_foreign` FOREIGN KEY (`asset_item_id`) REFERENCES `asset_items` (`id`),
  ADD CONSTRAINT `assets_asset_type_id_foreign` FOREIGN KEY (`asset_type_id`) REFERENCES `asset_types` (`id`),
  ADD CONSTRAINT `assets_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  ADD CONSTRAINT `assets_placement_id_foreign` FOREIGN KEY (`placement_id`) REFERENCES `placements` (`id`),
  ADD CONSTRAINT `fk_assets_created_by` FOREIGN KEY (`created_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assets_solved_by` FOREIGN KEY (`last_solved_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_assets_updated_by` FOREIGN KEY (`last_updated_by_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `asset_histories`
--
ALTER TABLE `asset_histories`
  ADD CONSTRAINT `fk_histories_asset` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_histories_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `passkeys`
--
ALTER TABLE `passkeys`
  ADD CONSTRAINT `passkeys_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
