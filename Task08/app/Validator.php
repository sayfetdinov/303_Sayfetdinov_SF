<?php declare(strict_types=1);

class Validator
{
    public function validateParameter($parameter): array
    {
        if ($parameter === null || $parameter === '') {
            return [true, ''];
        }

        if (!is_numeric($parameter)) {
            return [false, 'Doctor\'s ID must be a number'];
        }

        if ($parameter < 1) {
            return [false, 'Doctor\'s ID must be a number greater than zero'];
        }

        return [true, ''];
    }

    public function validatePost($paramsMap): array {
        $rulesMap = $this->getRulesMap();

        foreach ($paramsMap as $parameter => $rules) {
            foreach ($rules as $rule) {
                if (!$rulesMap[$rule]($_POST[$parameter])) {
                    return [false, $parameter, $rule];
                }
            }
        }

        return [true, null, null];
    }

    /**
     * @return array<string, Closure>
     */
    private function getRulesMap(): array
    {
        return [
            'string' => fn ($param) => is_string($param),
            'userName' => fn ($param) => preg_match('/[A-Za-zа-яА-Я]/u', $param),
            'int' => fn ($param) => is_int($param),
        ];
    }
}
