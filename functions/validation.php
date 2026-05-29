<?php
function required(array $data, array $fields): array
{
    $errors = [];
    foreach ($fields as $field) {
        if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . ' is required.';
        }
    }
    return $errors;
}

function validate_email_value(string $email): ?string
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? null : 'A valid email address is required.';
}

function ensure_year(string $year): ?string
{
    $value = (int) $year;
    return ($value >= 1990 && $value <= (int) date('Y') + 1) ? null : 'Academic year is invalid.';
}

