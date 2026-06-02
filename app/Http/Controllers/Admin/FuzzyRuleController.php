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

    public function create()
    {
        return view('admin.fuzzy-rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rule_number' => 'required|integer|unique:fuzzy_rules,rule_number',
            'antecedent_total' => 'nullable|string',
            'antecedent_cognitive' => 'nullable|string',
            'antecedent_somatic' => 'nullable|string',
            'consequent' => 'required|string',
            'is_active' => 'boolean',
        ]);

        FuzzyRule::create([
            'rule_number' => $validated['rule_number'],
            'antecedent_total' => isset($validated['antecedent_total']) ? \App\Enums\DepressionLevel::from($validated['antecedent_total']) : null,
            'antecedent_cognitive' => isset($validated['antecedent_cognitive']) ? \App\Enums\DepressionLevel::from($validated['antecedent_cognitive']) : null,
            'antecedent_somatic' => isset($validated['antecedent_somatic']) ? \App\Enums\DepressionLevel::from($validated['antecedent_somatic']) : null,
            'consequent' => \App\Enums\DepressionLevel::from($validated['consequent']),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.fuzzy-rules.index')
            ->with('success', "Aturan R" . sprintf('%03d', $validated['rule_number']) . " berhasil ditambahkan.");
    }

    public function edit(FuzzyRule $fuzzy_rule)
    {
        return view('admin.fuzzy-rules.edit', compact('fuzzy_rule'));
    }

    public function update(Request $request, $id)
    {
        $rule = FuzzyRule::findOrFail($id);
        
        $validated = $request->validate([
            'is_active' => 'nullable|boolean',
            'antecedent_total' => 'nullable|string',
            'antecedent_cognitive' => 'nullable|string',
            'antecedent_somatic' => 'nullable|string',
            'consequent' => 'nullable|string',
        ]);

        if ($request->has('is_active') && count($request->all()) <= 3) { // toggle active from index
            $rule->update([
                'is_active' => $validated['is_active'],
            ]);
            return redirect()->back()->with('success', "Aturan R" . sprintf('%03d', $rule->rule_number) . " berhasil diperbarui.");
        }

        // Full update from edit page
        $rule->update([
            'antecedent_total' => isset($validated['antecedent_total']) ? \App\Enums\DepressionLevel::from($validated['antecedent_total']) : null,
            'antecedent_cognitive' => isset($validated['antecedent_cognitive']) ? \App\Enums\DepressionLevel::from($validated['antecedent_cognitive']) : null,
            'antecedent_somatic' => isset($validated['antecedent_somatic']) ? \App\Enums\DepressionLevel::from($validated['antecedent_somatic']) : null,
            'consequent' => \App\Enums\DepressionLevel::from($validated['consequent']),
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.fuzzy-rules.index')->with('success', "Aturan R" . sprintf('%03d', $rule->rule_number) . " berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $rule = FuzzyRule::findOrFail($id);
        $ruleNumber = $rule->rule_number;
        $rule->delete();

        return redirect()->route('admin.fuzzy-rules.index')
            ->with('success', "Aturan R" . sprintf('%03d', $ruleNumber) . " berhasil dihapus.");
    }
}
