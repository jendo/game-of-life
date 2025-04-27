<?php

namespace App\Serializer\Normalizer;

use App\Game\Input\Life;
use App\Game\Input\Organism;
use App\Game\Input\World;
use ReflectionClass;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class LifeNormalizer implements DenormalizerInterface
{
    public const MISSING_FIELD_MESSAGE = 'The field %s is missing.';
    public const INVALID_FIELD_TYPE_MESSAGE = 'Invalid type provided. Expected %s.';

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null): bool
    {
        if (class_exists($type) === false) {
            throw new InvalidArgumentException(sprintf('Class %s does not exist.', $type));
        }

        if ($type !== Life::class) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid class to which the data should be denormalized. Expected %s but provided %s.',
                    Life::class,
                    $type
                )
            );
        }

        return true;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param string|null $format
     * @param array<mixed> $context
     * @return mixed
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $this->validateWorld($data);

        $this->validateOrganisms($data);

        return new $type(
            new World(
                (int) $data[Life::FIELD_WORLD][World::FIELD_CELLS],
                (int) $data[Life::FIELD_WORLD][World::FIELD_ITERATIONS]
            ),
            array_map(
                static function ($organismData): Organism {
                    return new Organism(
                        $organismData[Organism::FIELD_POSITION_X],
                        $organismData[Organism::FIELD_POSITION_Y]
                    );
                },
                $data[Life::FIELD_ORGANISMS][Life::FIELD_ORGANISM]
            )
        );
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    private function validateWorld(array $data): void
    {
        if (isset($data[Life::FIELD_WORLD]) === false) {
            throw new InvalidArgumentException(
                sprintf(self::MISSING_FIELD_MESSAGE, self::getNestedFieldName(Life::FIELD_WORLD))
            );
        }

        if (is_array($data[Life::FIELD_WORLD]) === false) {
            throw new InvalidArgumentException(
                sprintf(self::INVALID_FIELD_TYPE_MESSAGE, 'array')
            );
        }

        if (isset($data[Life::FIELD_WORLD][World::FIELD_CELLS]) === false) {
            throw new InvalidArgumentException(
                sprintf(self::MISSING_FIELD_MESSAGE, self::getNestedFieldName(Life::FIELD_WORLD, World::FIELD_CELLS))
            );
        }

        if (isset($data[Life::FIELD_WORLD][World::FIELD_ITERATIONS]) === false) {
            throw new InvalidArgumentException(
                sprintf(self::MISSING_FIELD_MESSAGE, self::getNestedFieldName(Life::FIELD_WORLD, World::FIELD_ITERATIONS))
            );
        }
    }

    /**
     * @param array<string, mixed> $data
     * @return void
     */
    private function validateOrganisms(array $data): void
    {
        if (isset($data[Life::FIELD_ORGANISMS][Life::FIELD_ORGANISM]) === false) {
            throw new InvalidArgumentException(
                sprintf(self::MISSING_FIELD_MESSAGE, self::getNestedFieldName(Life::FIELD_ORGANISMS, Life::FIELD_ORGANISM))
            );
        }

        if (is_array($data[Life::FIELD_ORGANISMS][Life::FIELD_ORGANISM]) === false) {
            throw new InvalidArgumentException(sprintf(self::INVALID_FIELD_TYPE_MESSAGE, 'array'));
        }

        foreach ($data[Life::FIELD_ORGANISMS][Life::FIELD_ORGANISM] as $organism) {
            if (is_array($organism) === false) {
                throw new InvalidArgumentException(sprintf(self::INVALID_FIELD_TYPE_MESSAGE, 'array'));
            }

            if (isset($organism[Organism::FIELD_POSITION_Y]) === false) {
                throw new InvalidArgumentException(
                    sprintf(
                        self::MISSING_FIELD_MESSAGE,
                        self::getNestedFieldName(Life::FIELD_ORGANISMS, Life::FIELD_ORGANISM, Organism::FIELD_POSITION_Y)
                    )
                );
            }

            if (isset($organism[Organism::FIELD_POSITION_X]) === false) {
                throw new InvalidArgumentException(
                    sprintf(
                        self::MISSING_FIELD_MESSAGE,
                        self::getNestedFieldName(Life::FIELD_ORGANISMS, Life::FIELD_ORGANISM, Organism::FIELD_POSITION_X)
                    )
                );
            }
        }
    }

    private static function getNestedFieldName(string ...$fields): string
    {
        return self::getRootFieldName() . '.' . implode('.', $fields);
    }

    private static function getRootFieldName(): string
    {
        return strtolower((new ReflectionClass(Life::class))->getShortName());
    }
}
