<?php

namespace App\Models;

use App\Enums\MembershipFunctionType;
use App\Enums\DepressionLevel;
use Illuminate\Database\Eloquent\Model;

class FuzzyMembershipParam extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'function_type' => MembershipFunctionType::class,
            'linguistic_label' => DepressionLevel::class,
            'param_a' => 'decimal:2',
            'param_b' => 'decimal:2',
            'param_c' => 'decimal:2',
            'param_d' => 'decimal:2',
        ];
    }
}
