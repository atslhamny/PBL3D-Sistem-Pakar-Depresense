<?php

namespace App\Models;

use App\Enums\DepressionLevel;
use Illuminate\Database\Eloquent\Model;

class FuzzyRule extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'antecedent_total' => DepressionLevel::class,
            'antecedent_cognitive' => DepressionLevel::class,
            'antecedent_somatic' => DepressionLevel::class,
            'consequent' => DepressionLevel::class,
            'is_active' => 'boolean',
            'rule_number' => 'integer',
        ];
    }
}
