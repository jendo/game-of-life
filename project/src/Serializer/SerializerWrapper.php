<?php

declare(strict_types=1);

namespace App\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

class SerializerWrapper
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $data The serialized data.
     * @param string $type The target class type.
     * @param string $format The format of the serialized data (e.g., 'xml', 'json').
     * @param array<string, mixed> $context Additional context for deserialization.
     * @return mixed The deserialized object.
     */
    public function deserialize(string $data, string $type, string $format, array $context = []): mixed
    {
        return $this->serializer->deserialize($data, $type, $format, $context);
    }
}
