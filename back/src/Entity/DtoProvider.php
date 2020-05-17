<?php


namespace App\Entity;


interface DtoProvider
{
    public function populateFromDto($dto, $context = []);
    public function getDto();
}