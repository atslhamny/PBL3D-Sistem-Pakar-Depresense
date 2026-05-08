<?php

namespace App\Models;

use App\Enums\QuestionCategory;
use App\Enums\QuestionSubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class BdiQuestion extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'category' => QuestionCategory::class,
            'sub_category' => QuestionSubCategory::class,
            'is_safety_item' => 'boolean',
            'is_locked' => 'boolean',
            'item_number' => 'integer',
            'safety_threshold' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SessionAnswer::class, 'question_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query;
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeSafetyItem(Builder $query): Builder
    {
        return $query->where('is_safety_item', true);
    }
}
