<?php
namespace Validate;

class Validator
{
    public function validate($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = filter_var($data, FILTER_SANITIZE_STRING);

        return $data;
    }
}