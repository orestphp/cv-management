<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institution_name',
        'period_from',
        'period_to',
        'faculty',
        'address',
        'summary',
        'website',
        'cv_id'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
