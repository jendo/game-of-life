<?php

declare(strict_types=1);

namespace App\Game\Input;

use App\Serializer\SerializerWrapper;
use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class LifeInputSerializer
{
    private SerializerWrapper $serializerWrapper;

    public function __construct(SerializerWrapper $serializerWrapper)
    {
        $this->serializerWrapper = $serializerWrapper;
    }

    /**
     * @param string $xmlData
     * @return Life
     * @throws InvalidArgumentException
     */
    public function deserialize(string $xmlData): Life
    {
        try {
            return $this->serializerWrapper->deserialize($xmlData, Life::class, 'xml');
        } catch (NotEncodableValueException $e) {
            throw new InvalidArgumentException(sprintf('Failed to decode XML data: %s', $e->getMessage()), 0, $e);
        }
    }
}
