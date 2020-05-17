<?php

namespace App\Controller;

use App\Dto\WordDto;

/**
 * Class WordsControllerRpc
 * @package App\Controller
 */
class WordsController
{
    public function __invoke(WordDto $data): WordDto
    {
        return $data;
    }
}