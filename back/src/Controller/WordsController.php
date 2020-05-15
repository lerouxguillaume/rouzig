<?php

namespace App\Controller;

use App\Dto\WordDto;
use App\Handler\WordDtoHandler;

/**
 * Class WordsControllerRpc
 * @package App\Controller
 */
class WordsController
{
    /** @var WordDtoHandler */
    private $wordsDtoHandler;

    /**
     * WordsController constructor.
     * @param WordDtoHandler $wordsDtoHandler
     */
    public function __construct(WordDtoHandler $wordsDtoHandler)
    {
        $this->wordsDtoHandler = $wordsDtoHandler;
    }

    public function __invoke(WordDto $data): WordDto
    {
        $this->wordsDtoHandler->validate($data);
        return $data;
    }
}