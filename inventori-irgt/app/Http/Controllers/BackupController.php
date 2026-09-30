<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    /**
     * Mengunduh file backup database (.sql) langsung dari sistem.
     * Khusus Super Admin.
     */
    public function download(): StreamedResponse
    {
        $dbName = config('database.connections.mysql.database');
        $filename = 'backup_' . $dbName . '_' . date('Y-m-d_His') . '.sql';

        $headers = [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($dbName) {
            $handle = fopen('php://output', 'w');

            // Header SQL Dump
            fwrite($handle, "-- ========================================================\n");
            fwrite($handle, "-- IRGT School Inventory System - Database Backup\n");
            fwrite($handle, "-- Database: {$dbName}\n");
            fwrite($handle, "-- Generated at: " . date('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- ========================================================\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
            fwrite($handle, "SET time_zone = \"+00:00\";\n\n");

            // Ambil semua nama tabel
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . $dbName;

            foreach ($tables as $tableObj) {
                $tableName = $tableObj->$tableKey ?? array_values((array) $tableObj)[0];

                // Struktur tabel (CREATE TABLE)
                $createTableRes = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $createTableSql = $createTableRes[0]->{'Create Table'} ?? null;

                if ($createTableSql) {
                    fwrite($handle, "\n-- --------------------------------------------------------\n");
                    fwrite($handle, "-- Table structure for table `{$tableName}`\n");
                    fwrite($handle, "-- --------------------------------------------------------\n");
                    fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");
                    fwrite($handle, $createTableSql . ";\n\n");
                }

                // Data tabel (INSERT INTO)
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    fwrite($handle, "-- Dumping data for table `{$tableName}`\n");
                    
                    foreach ($rows as $row) {
                        $rowArray = (array) $row;
                        $columns = array_keys($rowArray);
                        $escapedColumns = array_map(fn($col) => "`{$col}`", $columns);
                        
                        $values = array_map(function ($val) {
                            if (is_null($val)) {
                                return 'NULL';
                            }
                            // Escape karakter kutip dan backslash
                            $escaped = addslashes($val);
                            $escaped = str_replace(["\r\n", "\r", "\n"], ["\\r\\n", "\\r", "\\n"], $escaped);
                            return "'{$escaped}'";
                        }, array_values($rowArray));

                        $insertSql = "INSERT INTO `{$tableName}` (" . implode(', ', $escapedColumns) . ") VALUES (" . implode(', ', $values) . ");\n";
                        fwrite($handle, $insertSql);
                    }
                    fwrite($handle, "\n");
                }
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
            fwrite($handle, "-- Backup completed.\n");

            fclose($handle);
        }, 200, $headers);
    }
}
