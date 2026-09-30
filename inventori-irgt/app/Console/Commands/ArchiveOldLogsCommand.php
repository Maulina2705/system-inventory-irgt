<?php

namespace App\Console\Commands;

use App\Models\AssetHistory;
use App\Models\AssetHistoryArchive;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArchiveOldLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:archive {--years=2 : Number of years before logs are archived} {--dry-run : Simulate archiving without moving records}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely archive activity logs / asset histories older than 2 years into the archive table';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $years = (int) $this->option('years') ?: 2;
        $dryRun = (bool) $this->option('dry-run');
        $cutoffDate = Carbon::now()->subYears($years);

        $this->info("Scanning logs older than {$years} years (cutoff date: {$cutoffDate->toDateTimeString()})...");

        $oldLogsQuery = AssetHistory::where('created_at', '<', $cutoffDate);
        $count = $oldLogsQuery->count();

        if ($count === 0) {
            $this->info("No logs older than {$years} years found. Archive operation complete.");
            return Command::SUCCESS;
        }

        $this->info("Found {$count} log record(s) eligible for archiving.");

        if ($dryRun) {
            $this->warn("[DRY RUN] {$count} records would be moved to asset_histories_archive.");
            return Command::SUCCESS;
        }

        $this->output->progressStart($count);

        $archivedCount = 0;

        DB::beginTransaction();

        try {
            // Process in chunks of 500 for memory safety
            AssetHistory::where('created_at', '<', $cutoffDate)
                ->chunkById(500, function ($records) use (&$archivedCount) {
                    $insertData = [];

                    foreach ($records as $record) {
                        $insertData[] = [
                            'asset_id' => $record->asset_id,
                            'user_id' => $record->user_id,
                            'action' => $record->action,
                            'old_status' => $record->old_status,
                            'new_status' => $record->new_status,
                            'notes' => $record->notes,
                            'original_created_at' => $record->created_at,
                            'original_updated_at' => $record->updated_at,
                            'archived_at' => Carbon::now(),
                        ];
                    }

                    if (!empty($insertData)) {
                        DB::table('asset_histories_archive')->insert($insertData);
                        $ids = $records->pluck('id')->toArray();
                        DB::table('asset_histories')->whereIn('id', $ids)->delete();
                        $archivedCount += count($insertData);
                        $this->output->progressAdvance(count($insertData));
                    }
                });

            DB::commit();
            $this->output->progressFinish();
            $this->info("Successfully archived {$archivedCount} log record(s) to asset_histories_archive.");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->output->progressFinish();
            $this->error("Failed to archive logs: " . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
