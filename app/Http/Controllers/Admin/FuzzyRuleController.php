<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuzzyRule;
use Illuminate\Http\Request;

class FuzzyRuleController extends Controller
{
    public function index()
    {
        $rules = FuzzyRule::orderBy('rule_number', 'asc')->get();
        
        $totalRules = $rules->count();
        $inactiveRules = $rules->where('is_active', false)->count();
        
        return view('admin.fuzzy-rules.index', compact('rules', 'totalRules', 'inactiveRules'));
    }

    public function update(Request $request, $id)
    {
        $rule = FuzzyRule::findOrFail($id);
        
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $rule->update([
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->back()->with('success', "Aturan R" . sprintf('%03d', $rule->rule_number) . " berhasil diperbarui.");
    }
}
