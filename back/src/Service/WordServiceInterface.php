<?php

namespace App\Service;

use App\Entity\WordObject;

interface WordServiceInterface
{
    public function save(WordObject $wordObject);
    public function update(int $id, WordObject $wordObject) : WordObject;
    public function delete(WordObject $wordObject);
    public function findById(int $id) : ?WordObject;
    public function findByStatus(string $status): array;
    public function search(string $search): array;
}