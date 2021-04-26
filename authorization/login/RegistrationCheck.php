<?php


class RegistrationCheck
{
    public function checkPassword($password)
    {
        if (strlen($password) < 8) {
            return [
                'result' => 'failed',
                'details' => 'Пароль не соответствует требованиям (минимум 8 символов)',
            ];
        } else {
            return $password;
        }
    }

    public function isHaveValueInDb($connection, string $tableName, string $property, string $value)
    {
        $result = $connection->query("SELECT * FROM $tableName WHERE $property = '$value'");

        $result = $result->fetch_assoc();
        if (!empty($result)) {
            return [
                'result' => 'activeAccount',
                'details' => "Пользователь с таким {$property} уже есть",
            ];
        } else {
            return $value;
        }
    }
}