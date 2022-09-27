<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position',
        'company_name',
        'company_website',
        'period_from',
        'period_to',
        'summary',
        'tech_stack',
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
