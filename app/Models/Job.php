<?php

 

namespace App\Models;

 

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

 

class Job extends Model

{

    use HasFactory;

 

    protected $fillable = [

        'user_id', 'title', 'company', 'description', 'location', 'website', 'logo', 'email', 'tags',

    ];

 

    protected static function boot()

    {

        parent::boot();

        static::creating(function (Job $item) {

            if($item->user_id == null){

                $item->user_id = Auth::user()?->id;

            }

        });

    }

 

    public function scopeFilter($query, array $filters)

    {

        if ($filters['tag'] ?? false) {

            $query->where('tags', 'like', '%' . request('tag') . '%');

        }

 

        if ($filters['search'] ?? false) {

            $query->where('title', 'like', '%' . request('search') . '%')

                ->orWhere('tags', 'like', '%' . request('search') . '%')

                ->orWhere('location', 'like', '%' . request('search') . '%')

                ->orWhere('company', 'like', '%' . request('search') . '%');

        }

    }

 

    // Relationship to User

    public function user()

    {

        return $this->belongsTo(User::class, 'user_id');

    }

}

 
