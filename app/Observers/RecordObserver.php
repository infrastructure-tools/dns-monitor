<?php

namespace App\Observers;

use App\Record;

class RecordObserver
{
    /**
     * Handle the record "created" event.
     *
     * @param  \App\Record  $record
     * @return void
     */
    public function creating(Record $record)
    {
        $previous = $record->previous()->first();

        if(!$previous) {
            return true;
        }

        $previousData = json_decode($previous->data);
        $currentData = json_decode($record->data);
        array_walk($previousData, 'App\Observers\RecordObserver::jsonEncode');
        array_walk($currentData, 'App\Observers\RecordObserver::jsonEncode');
        $removed = array_diff($previousData, $currentData);
        $added = array_diff($currentData, $previousData);
        var_dump($removed, $added);
    }

    private function jsonEncode(&$value) {
        $value = json_encode($value);
    }

}
