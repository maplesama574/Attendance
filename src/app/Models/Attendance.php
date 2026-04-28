<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_datetime',
        'end_datetime',
        'user_id',
        'status',
        'remarks',
        'approval_datetime',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'approval_datetime' => 'datetime',
    ];

    // 休憩とのリレーション
    public function breakTimes()
    {
        return $this->hasMany(BreakTime::class);
    }

    // 休憩合計
    public function getBreakTotalAttribute()
    {
        $total = 0;

        foreach ($this->breakTimes as $break) {
            if ($break->break_start && $break->break_end) {
                $total += $break->break_start->diffInMinutes($break->break_end);
            }
        }

        return $total;
    }

    // 勤務時間
    public function getWorkTimeAttribute()
    {
        if (!$this->start_datetime || !$this->end_datetime) {
            return null;
        }

        $minutes = $this->start_datetime
            ->diffInMinutes($this->end_datetime) - $this->break_total;

        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        return sprintf('%02d:%02d', $hours, $mins);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}