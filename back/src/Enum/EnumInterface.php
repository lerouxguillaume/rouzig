<?php


namespace App\Enum;


interface EnumInterface
{
    public static function getArray(): array;
    public static function get(string $key);
}