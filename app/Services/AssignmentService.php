<?php

namespace App\Services;

use App\Models\DriverRoute;
use App\Models\RecipientRoute;
use Illuminate\Support\Facades\DB;

class AssignmentService
{

    /**
     * Create a Driver-Route relationship
     * 
     * @param int $route_id
     * @param int $driver_id
     * @param int $weekday
     */
    public function assign_driver($route_id, $driver_id, $weekday)
    {
        $driver_route = DriverRoute::where(
            [
                'route_id' => $route_id,
                'driver_id' => $driver_id,
                'weekday' => $weekday
            ]
        )->first();

        if (isset($driver_route))
            $driver_route->driver_id = $driver_id;

        else
            $driver_route = new DriverRoute([
                'route_id' => $route_id,
                'driver_id' => $driver_id,
                'weekday' => $weekday
            ]);

        $driver_route->save();
    }

    /**
     * Remove an existing Driver-Route relationship

     * @param int $route_id
     * @param int $driver_id
     * @param int $weekday
     */
    public function deassign_driver($route_id, $driver_id, $weekday)
    {
        DriverRoute::where(
            [
                'route_id' => $route_id,
                'driver_id' => $driver_id,
                'weekday' => $weekday
            ]
        )->delete();
    }

    /**
     * Create a Recipient-Route relationship
     *
     * @param int $route_id
     * @param int $recipient_id
     * @param int $weekday
     */
    public function assign_recipient($route_id, $recipient_id, $weekday)
    {
        $nextIndex = RecipientRoute::getNextOrderingIndex(
            $route_id,
            $weekday
        );
        RecipientRoute::upsert(
            [
                'route_id' => $route_id,
                'recipient_id' => $recipient_id,
                'weekday' => $weekday,
                'driver_custom_order' => $nextIndex
            ],
            ['route_id', 'weekday', 'recipient_id']
        );
    }

    /**
     * Remove an existing Recipient-Route relationship
     * Has side-effect of updating driver_custom_order field of subsequent rows
     *
     * @param int $route_id
     * @param int $recipient_id
     * @param int $weekday
     */
    public function deassign_recipient($route_id, $recipient_id, $weekday)
    {
        // Assignment record to be deleted
        $assignment = RecipientRoute::where(
            [
                'route_id' => $route_id,
                'recipient_id' => $recipient_id,
                'weekday' => $weekday,
            ]
        )->first();

        // Driver-specified ordering index
        $deletedIndex = $assignment->driver_custom_order;

        DB::beginTransaction();

        $assignment->delete();

        // Records following deleted record ordered by driver ordering index
        $recordsAfter = RecipientRoute::where(
            [
                'route_id' => $route_id,
                'weekday' => $weekday,
            ]
        )
            ->where('driver_custom_order', '>', $deletedIndex)
            ->orderBy('driver_custom_order')
            ->get();

        // Temp variable for iterating and updating subsequent records
        $i = $deletedIndex;

        // Update index of records after deleted record
        $recordsAfter->each(function ($record) use (&$i) {
            $record->driver_custom_order = $i;
            $record->save();
            $i++;
        });

        DB::commit();
    }

    /**
     * Reorders a Recipient-Route record's driver_custom_order field in-place
     * 
     * @param int $route_id
     * @param int $recipient_id
     * @param int $weekday
     * @param int $new_order
     */
    public function reorder_recipient($route_id, $recipient_id, $weekday, $new_order)
    {
        // Retrieve record being moved
        $movedRecord = RecipientRoute::where([
            'route_id' => $route_id,
            'weekday' => $weekday,
            'recipient_id' => $recipient_id
        ])->first();

        $current_order = $movedRecord->driver_custom_order;


        DB::beginTransaction();
        // Moving recipient lower in order
        if ($current_order > $new_order) {
            // Retrieve subsequent records to shift up
            $recordsToMoveUp = RecipientRoute::where(['route_id' => $route_id, 'weekday' => $weekday])
                ->where('driver_custom_order', '>=', $new_order)
                ->where('driver_custom_order', '<', $current_order)
                ->orderBy('driver_custom_order')
                ->get();

            $i = $new_order;

            // Move up following records
            $recordsToMoveUp->each(function ($record) use (&$i) {
                // $record->driver_custom_order = $i + 1;
                $record->driver_custom_order += 1;
                $record->save();
                $i++;
            });
        }
        // Moving recipient higher in order
        else if ($current_order < $new_order) {
            // Retrieve previous records to shift down
            $recordsToMoveDown = RecipientRoute::where(['route_id' => $route_id, 'weekday' => $weekday])
                ->where('driver_custom_order', '<=', $new_order)
                ->where('driver_custom_order', '>', $current_order)
                // ->orderBy('driver_custom_order', 'desc')
                ->orderBy('driver_custom_order')
                ->get();

            $i = $new_order;

            // Move up following records
            $recordsToMoveDown->each(function ($record) use (&$i) {
                // $record->driver_custom_order = $i - 1;
                $record->driver_custom_order -= 1;
                $record->save();
                $i--;
            });
        }

        // Move reordered record
        $movedRecord->driver_custom_order = $new_order;
        $movedRecord->save();
        DB::commit();
    }
}
