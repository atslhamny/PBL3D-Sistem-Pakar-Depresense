<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BdiQuestion;
use App\Enums\QuestionSubCategory;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = BdiQuestion::ordered()->get();
        
        $cognitiveQuestions = $questions->where('sub_category', QuestionSubCategory::Kognitif);
        $somaticQuestions = $questions->where('sub_category', QuestionSubCategory::Fisik);
        
        $totalCount = $questions->count();
        $checkedCount = $questions->where('is_locked', true)->count();
        $progressPercent = $totalCount > 0 ? round(($checkedCount / $totalCount) * 100) : 0;

        return view('admin.questions.index', compact(
            'cognitiveQuestions',
            'somaticQuestions',
            'totalCount',
            'checkedCount',
            'progressPercent'
        ));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_number'      => 'required|integer|unique:bdi_questions,item_number',
            'question_text'    => 'required|string',
            'category'         => 'required|in:kognitif_afektif,somatik',
            'sub_category'     => 'required|in:emosi,kognitif,fisik',
            'options'          => 'required|array|min:2',
            'options.*.score'  => 'required|integer|min:0',
            'options.*.text'   => 'required|string',
            'is_safety_item'   => 'boolean',
            'safety_threshold' => 'nullable|integer',
            'sort_order'       => 'required|integer',
        ]);

        $options = collect($request->options)->map(function ($opt) {
            return [
                'score' => (int) $opt['score'],
                'text' => $opt['text']
            ];
        })->toArray();

        BdiQuestion::create([
            'item_number'      => $validated['item_number'],
            'question_text'    => $validated['question_text'],
            'category'         => QuestionCategory::from($validated['category']),
            'sub_category'     => QuestionSubCategory::from($validated['sub_category']),
            'answer_options'   => $options,
            'is_safety_item'   => $request->has('is_safety_item'),
            'safety_threshold' => $validated['safety_threshold'] ?? null,
            'sort_order'       => $validated['sort_order'],
            'is_locked'        => false,
            'version'          => 1,
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan baru berhasil ditambahkan.');
    }

    public function edit(BdiQuestion $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, BdiQuestion $question)
    {
        if ($question->is_locked) {
            return redirect()->route('admin.questions.index')
                ->with('error', 'Pertanyaan ini terkunci dan tidak dapat diubah karena merupakan standar BDI-II.');
        }

        $validated = $request->validate([
            'item_number'      => 'required|integer|unique:bdi_questions,item_number,' . $question->id,
            'question_text'    => 'required|string',
            'category'         => 'required|in:kognitif_afektif,somatik',
            'sub_category'     => 'required|in:emosi,kognitif,fisik',
            'options'          => 'required|array|min:2',
            'options.*.score'  => 'required|integer|min:0',
            'options.*.text'   => 'required|string',
            'is_safety_item'   => 'boolean',
            'safety_threshold' => 'nullable|integer',
            'sort_order'       => 'required|integer',
        ]);

        $options = collect($request->options)->map(function ($opt) {
            return [
                'score' => (int) $opt['score'],
                'text' => $opt['text']
            ];
        })->toArray();

        $question->update([
            'item_number'      => $validated['item_number'],
            'question_text'    => $validated['question_text'],
            'category'         => QuestionCategory::from($validated['category']),
            'sub_category'     => QuestionSubCategory::from($validated['sub_category']),
            'answer_options'   => $options,
            'is_safety_item'   => $request->has('is_safety_item'),
            'safety_threshold' => $validated['safety_threshold'] ?? null,
            'sort_order'       => $validated['sort_order'],
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(BdiQuestion $question)
    {
        if ($question->is_locked) {
            return redirect()->route('admin.questions.index')
                ->with('error', 'Pertanyaan terkunci tidak dapat dihapus.');
        }

        $question->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
