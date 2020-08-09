<?php

namespace App\Service\Serializer;

use App\Entity\WordObject;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class WordSerializer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'text' => $object->getText()
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof WordObject;
    }
}