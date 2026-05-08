<?php

namespace App\Repositories;

use App\Models\BdiQuestion;

class QuestionRepository
{
    public function getActiveOrdered()
    {
        return BdiQuestion::active()->ordered()->get();
    }

    public function getByItemNumber(int $itemNumber): ?BdiQuestion
    {
        return BdiQuestion::where('item_number', $itemNumber)->first();
    }
}
