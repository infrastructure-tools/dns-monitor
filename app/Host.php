<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    protected $fillable = [
        'hostname',
        'flags'
    ];

    public function process()
    {
        $records = dns_get_record($this->hostname, $this->flags);

        array_walk($records, function (&$record) {
            unset($record['host']);
            unset($record['class']);
            unset($record['ttl']);
            ksort($record);
        });

        usort($records, function ($a, $b) {
            $aJson = json_encode($a);
            $bJson = json_encode($b);
            if ($aJson === $bJson) {
                return 0;
            } else {
                return ($aJson < $bJson) ? -1 : 1;
            }
        });

        $record = $this->records()->create([
            'data' => json_encode($records)
        ]);
    }

    public function records()
    {
        return $this
            ->hasMany('App\Record');
    }

    public function scopeHostnameIn($query, $hostnames)
    {
        return $query
            ->whereIn('hostnames', (array)$hostnames);
    }
}
