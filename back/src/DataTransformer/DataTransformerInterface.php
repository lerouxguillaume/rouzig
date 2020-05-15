<?php

namespace App\DataTransformer;

interface DataTransformerInterface
{
    public function populateDto($word);
    public function populateEntity($word, $wordObject = null, $context = []);
}