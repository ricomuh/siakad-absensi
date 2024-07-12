<?php

namespace App\Enums;

enum RoleEnum
{
    case ADMIN;
    case TEACHER;
    case STUDENT;

    public static function toArray(): array
    {
        return [
            self::ADMIN => 'admin',
            self::TEACHER => 'teacher',
            self::STUDENT => 'student',
        ];
    }
}
