<?php

namespace RadFic\Gastropod\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;


class GastropodAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the admin record.
     */
    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
