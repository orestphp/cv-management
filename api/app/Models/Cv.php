<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $table = 'cv';

    public function formatDate( $value ) {
        return (new Carbon($value))->format('Y-m-d');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'first_name',
        'surname',
        'middle_name',
        'date_of_birth',
        'email',
        'phone',
        'avatar',
        'address',
        'linkedin',
        'skype',
        'website',
        'about_me',
        'technology_experience',
    ];

    /**
     * Get the address associated with the user.
     */
    public function education()
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Get the address associated with the user.
     */
    public function workExperience()
    {
        return $this->hasMany(WorkExperience::class);
    }
}
