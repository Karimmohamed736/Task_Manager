<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function scopeSearch($query, ?string $term)
    {
        if ($term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")->orWhere('status', 'like', "%{$term}%");
        });
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
