<?php

declare(strict_types=1);

namespace App\Game\Input\Validation;

use App\Game\Input\Life;
use App\Game\Input\Organism;
use App\Game\Input\World;

class LifeStateValidator
{
    /**
     * @throws InvalidStateException
     */
    public function validate(Life $life): void
    {
        $errors = [];

        $errors = array_merge($errors, $this->validateWorld($life));
        $errors = array_merge($errors, $this->validateOrganisms($life));

        if ($errors !== []) {
            throw InvalidStateException::createFromErrors($errors);
        }
    }

    /**
     * @param Life $life
     * @return Error[]
     */
    private function validateWorld(Life $life): array
    {
        $errors = [];

        if ($life->getWorld()->getCells() <= 0) {
            $errors[] = new Error(sprintf('The number of %s must be greater than 0.', World::FIELD_CELLS));
        }

        if ($life->getWorld()->getIterations() <= 0) {
            $errors[] = new Error(sprintf('The number of %s must be greater than 0.', World::FIELD_ITERATIONS));
        }

        return $errors;
    }

    /**
     * @param Life $life
     * @return Error[]
     */
    private function validateOrganisms(Life $life): array
    {
        $errors = [];
        $positions = [];

        foreach ($life->getOrganisms() as $organism) {
            $x = $organism->getXPosition();
            $y = $organism->getYPosition();

            if ($x < 0 || $x >= $life->getWorld()->getCells()) {
                $errors[] = new Error(sprintf('Organism %s (%d) is out of bounds.', Organism::FIELD_POSITION_X, $x));
            }

            if ($y < 0 || $y >= $life->getWorld()->getCells()) {
                $errors[] = new Error(sprintf('Organism %s (%d) is out of bounds.', Organism::FIELD_POSITION_Y, $y));
            }

            $positionKey = sprintf('%d-%d', $x, $y);
            if (isset($positions[$positionKey])) {
                $errors[] = new Error(sprintf('Duplicate organism found at position (x:%d, y:%d).', $x, $y));
            }

            $positions[$positionKey] = true;
        }

        return $errors;
    }
}
