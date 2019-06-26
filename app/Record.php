<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Record extends Model
{

    protected $fillable = [
        'data'
    ];

    public function host()
    {
        return $this
            ->belongsTo('App\Host');
    }

    public function scopeLast($query)
    {
        return $query
            ->orderBy('created_at', 'desc')
            ->limit(1);
    }

    public function scopeSameHost($query, Record $record){
        return $query->where('host_id', $record->host_id);
    }

    public function scopeBeforeDate($query, $date)
    {
        return $query->where('created_at','<', $date);
    }

    public function scopeBeforeRecord($query, Record $record)
    {
        $date = $record->created_at ?: Carbon::now();
        return $query->beforeDate($date);
    }

    public function previous()
    {
        return static::sameHost($this)->beforeRecord($this)->last();
    }
}
