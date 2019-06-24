<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        return $this
            ->orderBy('created_at', 'desc')
            ->limit(1);
    }

    public function scopeBeforeDate($query, $date)
    {
        return $this->where('created_at','<', $data);
    }

    public function scopeBeforeRecord($query, Record $record)
    {
        return $this->beforeDate($record->created_at);
    }

    public function previous()
    {
        return static::beforeRecord($this)->last();
    }
}
