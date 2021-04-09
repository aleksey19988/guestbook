<?php
namespace Validate;

class Validator
{
    public function validate($data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
}