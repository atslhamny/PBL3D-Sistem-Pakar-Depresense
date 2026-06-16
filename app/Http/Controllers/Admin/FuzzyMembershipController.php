<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FuzzyMembershipParam;
use Illuminate\Http\Request;

class FuzzyMembershipController extends Controller
{
    public function index()
    {
        $params = FuzzyMembershipParam::orderBy('variable_name')->orderBy('linguistic_label')->get();

        // Group by variable_name for organized display
        $grouped = $params->groupBy('variable_name');

        $totalParams = $params->count();
        $totalVariables = $grouped->count();

        return view('admin.fuzzy-memberships.index', compact('grouped', 'totalParams', 'totalVariables'));
    }

    public function update(Request $request, FuzzyMembershipParam $fuzzyMembership)
    {
        $validated = $request->validate([
            'param_a' => 'required|numeric',
            'param_b' => 'required|numeric|gte:param_a',
            'param_c' => 'required|numeric|gte:param_b',
            'param_d' => 'required|numeric|gte:param_c',
        ], [
            'param_b.gte' => 'Nilai b harus >= a',
            'param_c.gte' => 'Nilai c harus >= b',
            'param_d.gte' => 'Nilai d harus >= c',
        ]);

        $fuzzyMembership->update($validated);

        return redirect()->back()->with('success',
            'Parameter fungsi keanggotaan "' . ucfirst($fuzzyMembership->variable_name) . ' - ' . ucfirst($fuzzyMembership->linguistic_label->value) . '" berhasil diperbarui.'
        );
    }
}
