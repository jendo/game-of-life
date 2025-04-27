<?php

declare(strict_types=1);

namespace App\Game\Input;

use App\Game\Input\Validation\InvalidStateException;
use App\Game\Input\Validation\LifeStateValidator;
use InvalidArgumentException;

class LifeInputProcessor
{
    private LifeInputSerializer $lifeInputSerializer;

    private LifeStateValidator $lifeStateValidator;

    public function __construct(
        LifeInputSerializer $lifeInputSerializer,
        LifeStateValidator $lifeStateValidator
    ) {
        $this->lifeInputSerializer = $lifeInputSerializer;
        $this->lifeStateValidator = $lifeStateValidator;
    }

    /**
     * Processes XML data to create and validate a Life object.
     *
     * @param string $xmlData
     * @return Life
     * @throws InvalidStateException
     * @throws InvalidArgumentException
     */
    public function process(string $xmlData): Life
    {
        $life = $this->lifeInputSerializer->deserialize($xmlData);

        $this->lifeStateValidator->validate($life);

        return $life;
    }
}
