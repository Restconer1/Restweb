<?php

namespace App\Helpers;

class Validator
{
    private array $errors = [];

    public function __construct(private array $data)
    {
    }

    public function required(string $field, string $label = null): self
    {
        $label = $label ?? $field;
        if (empty(trim((string) ($this->data[$field] ?? '')))) {
            $this->errors[$field][] = "{$label} is required.";
        }
        return $this;
    }

    public function email(string $field): self
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = 'Please enter a valid email address.';
        }
        return $this;
    }

    public function minLength(string $field, int $length, string $label = null): self
    {
        $label = $label ?? $field;
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field][] = "{$label} must be at least {$length} characters.";
        }
        return $this;
    }

    public function matches(string $field, string $otherField, string $label = null): self
    {
        $label = $label ?? $field;
        if (($this->data[$field] ?? null) !== ($this->data[$otherField] ?? null)) {
            $this->errors[$field][] = "{$label} does not match.";
        }
        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function firstError(): ?string
    {
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0];
        }
        return null;
    }
}
