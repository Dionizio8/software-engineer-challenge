<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FullTextSearch;

class User extends Model
{

    use FullTextSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'username',
        'name',
        'relevance',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'name',
        'username',
    ];
}
