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
            'antecedent_cognitive' => 'required|string',
            'antecedent_somatic' => 'required|string',
            'consequent' => 'required|string',
            'is_active' => 'boolean',
        ]);

        FuzzyRule::create([
            'rule_number' => $validated['rule_number'],
            'description' => 'Aturan R' . sprintf('%03d', $validated['rule_number']),
            'antecedent_cognitive' => \App\Enums\DepressionLevel::from($validated['antecedent_cognitive']),
            'antecedent_somatic' => \App\Enums\DepressionLevel::from($validated['antecedent_somatic']),
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
        
        // Toggle aktif dari tabel index (menggunakan _action flag eksplisit)
        if ($request->input('_action') === 'toggle') {
            $rule->update([
                'is_active' => (bool) $request->input('is_active'),
            ]);
            return redirect()->back()->with('success', "Aturan R" . sprintf('%03d', $rule->rule_number) . " berhasil diperbarui.");
        }

        // Full update dari halaman edit
        $validated = $request->validate([
            'is_active'            => 'nullable|boolean',
            'antecedent_cognitive' => 'required|string',
            'antecedent_somatic'   => 'required|string',
            'consequent'           => 'nullable|string',
        ]);

        $rule->update([
            'antecedent_cognitive' => \App\Enums\DepressionLevel::from($validated['antecedent_cognitive']),
            'antecedent_somatic'   => \App\Enums\DepressionLevel::from($validated['antecedent_somatic']),
            'consequent'           => \App\Enums\DepressionLevel::from($validated['consequent']),
            'is_active'            => $request->has('is_active'),
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
