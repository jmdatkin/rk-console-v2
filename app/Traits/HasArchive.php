<?php

namespace App\Traits;

use App\Carbon\RkCarbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HasArchive
{

    private static function doArchive()
    {
        $tableName = resolve(static::class)->getTable();
        $startOfWeek = RkCarbon::today()->startOf('week', Carbon::SUNDAY);
        DB::table($tableName)->get()
            ->each(function ($record) use ($startOfWeek, $tableName) {
                DB::table($tableName . '_archive')
                    ->insert(
                        array_merge(
                            (array)$record,
                            [
                                'resource_id' => $record->id,
                                'startOfWeek' => $startOfWeek
                            ]
                        )
                    );
            });
    }

    public static function archive($force = false)
    {
        $tableName = resolve(static::class)->getTable();
        $startOfWeek = RkCarbon::today()->startOf('week', Carbon::SUNDAY);
        $thisWeekArchiveExists = DB::table($tableName . '_archive')
            ->whereDate('startOfWeek', $startOfWeek)
            ->exists();

        if ($thisWeekArchiveExists) {
            Log::warning(
                'Archive of table ' . $tableName . ' already exists for week starting in ' . $startOfWeek->toString() . '.',
                [
                    'table' => $tableName,
                    'startOfWeek' => $startOfWeek
                ]
            );
            if ($force) {
                Log::info('Force is true, proceeding with archive.');
                self::doArchive();
            }
        } else {
            Log::info('Archiving table ' . $tableName . ' for week starting in ' . $startOfWeek->toString() . '.',
                [
                    'table' => $tableName,
                    'startOfWeek' => $startOfWeek
                ]
                );
            self::doArchive();
        }
    }
}
