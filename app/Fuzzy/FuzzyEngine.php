<?php

namespace App\Fuzzy;

use App\Fuzzy\DTOs\FuzzyInput;
use App\Fuzzy\DTOs\FuzzyResult;
use App\Models\FuzzyMembershipParam;
use App\Models\FuzzyRule;

class FuzzyEngine
{
    public function __construct(
        private Fuzzification $fuzzification,
        private RuleEvaluator $ruleEvaluator,
        private Aggregator $aggregator,
        private Defuzzifier $defuzzifier
    ) {}

    public function run(FuzzyInput $input): FuzzyResult
    {
        $params = FuzzyMembershipParam::all()->groupBy('variable_name');

        $totalParams = $this->formatParams($params->get('total', collect()));
        $cognitiveParams = $this->formatParams($params->get('cognitive', collect()));
        $somaticParams = $this->formatParams($params->get('somatic', collect()));
        $outputParams = $this->formatParams($params->get('output', collect()));

        $fuzzTotal = $this->fuzzification->fuzzify($input->total, $totalParams);
        $fuzzCognitive = $this->fuzzification->fuzzify($input->cognitive, $cognitiveParams);
        $fuzzSomatic = $this->fuzzification->fuzzify($input->somatic, $somaticParams);

        $rules = FuzzyRule::where('is_active', true)->get()->map(function ($rule) {
            return [
                'antecedent_total' => $rule->antecedent_total->value,
                'antecedent_cognitive' => $rule->antecedent_cognitive->value,
                'antecedent_somatic' => $rule->antecedent_somatic->value,
                'consequent' => $rule->consequent->value,
            ];
        })->toArray();

        $evaluatedRules = $this->ruleEvaluator->evaluate($fuzzTotal, $fuzzCognitive, $fuzzSomatic, $rules);

        $aggregated = $this->aggregator->aggregate($evaluatedRules);

        return $this->defuzzifier->centroid($aggregated, $outputParams);
    }

    private function formatParams($paramsCollection): array
    {
        $formatted = [];
        foreach ($paramsCollection as $param) {
            $formatted[$param->linguistic_label->value] = [
                'type' => $param->function_type->value,
                'a' => (float) $param->param_a,
                'b' => (float) $param->param_b,
                'c' => (float) $param->param_c,
                'd' => (float) $param->param_d,
            ];
        }
        return $formatted;
    }
}
