<?php

namespace App\Controller;

use App\Dto\TranslationDto;

/**
 * Class WordsControllerRpc
 * @package App\Controller
 */
class TranslationsController
{
    public function __invoke(TranslationDto $data): TranslationDto
    {
        return $data;
    }
}