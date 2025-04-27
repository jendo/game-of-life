<?php

declare(strict_types=1);

namespace AppTest\Unit\Game\Input;

use App\Game\Input\Life;
use App\Game\Input\Organism;
use App\Game\Input\Validation\InvalidStateException;
use App\Game\Input\Validation\LifeStateValidator;
use App\Game\Input\World;
use PHPUnit\Framework\TestCase;

class LifeStateValidatorTest extends TestCase
{
    private LifeStateValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new LifeStateValidator();
    }

    public function testValidatePassesForValidLifeState(): void
    {
        $world = $this->createMock(World::class);
        $world->method('getCells')->willReturn(5);
        $world->method('getIterations')->willReturn(10);

        $organism1 = $this->createMock(Organism::class);
        $organism1->method('getXPosition')->willReturn(1);
        $organism1->method('getYPosition')->willReturn(1);

        $organism2 = $this->createMock(Organism::class);
        $organism2->method('getXPosition')->willReturn(2);
        $organism2->method('getYPosition')->willReturn(2);

        $life = $this->createMock(Life::class);
        $life->method('getWorld')->willReturn($world);
        $life->method('getOrganisms')->willReturn([$organism1, $organism2]);

        $this->expectNotToPerformAssertions();
        $this->validator->validate($life);
    }

    public function testValidateThrowsExceptionForInvalidWorld(): void
    {
        $world = $this->createMock(World::class);
        $world->method('getCells')->willReturn(0);
        $world->method('getIterations')->willReturn(-1);

        $life = $this->createMock(Life::class);
        $life->method('getWorld')->willReturn($world);
        $life->method('getOrganisms')->willReturn([]);

        try {
            $this->validator->validate($life);
            self::fail('Expected InvalidStateException was not thrown.');
        } catch (InvalidStateException $exception) {
            $errors = $exception->getErrors();
            self::assertCount(2, $errors);
            self::assertSame('The number of cells must be greater than 0.', $errors[0]->getMessage());
            self::assertSame('The number of iterations must be greater than 0.', $errors[1]->getMessage());
        }
    }

    public function testValidateThrowsExceptionForInvalidOrganismPositions(): void
    {
        $world = $this->createMock(World::class);
        $world->method('getCells')->willReturn(5);
        $world->method('getIterations')->willReturn(10);

        $organism1 = $this->createMock(Organism::class);
        $organism1->method('getXPosition')->willReturn(6);
        $organism1->method('getYPosition')->willReturn(2);

        $organism2 = $this->createMock(Organism::class);
        $organism2->method('getXPosition')->willReturn(2);
        $organism2->method('getYPosition')->willReturn(6);

        $life = $this->createMock(Life::class);
        $life->method('getWorld')->willReturn($world);
        $life->method('getOrganisms')->willReturn([$organism1, $organism2]);

        try {
            $this->validator->validate($life);
            self::fail('Expected InvalidStateException was not thrown.');
        } catch (InvalidStateException $exception) {
            $errors = $exception->getErrors();
            self::assertCount(2, $errors);
            self::assertSame('Organism x_pos (6) is out of bounds.', $errors[0]->getMessage());
            self::assertSame('Organism y_pos (6) is out of bounds.', $errors[1]->getMessage());
        }
    }

    public function testValidateThrowsExceptionForDuplicateOrganisms(): void
    {
        $world = $this->createMock(World::class);
        $world->method('getCells')->willReturn(5);
        $world->method('getIterations')->willReturn(10);

        $organism1 = $this->createMock(Organism::class);
        $organism1->method('getXPosition')->willReturn(2);
        $organism1->method('getYPosition')->willReturn(2);

        $organism2 = $this->createMock(Organism::class);
        $organism2->method('getXPosition')->willReturn(2);
        $organism2->method('getYPosition')->willReturn(2);

        $life = $this->createMock(Life::class);
        $life->method('getWorld')->willReturn($world);
        $life->method('getOrganisms')->willReturn([$organism1, $organism2]);

        try {
            $this->validator->validate($life);
            self::fail('Expected InvalidStateException was not thrown.');
        } catch (InvalidStateException $exception) {
            $errors = $exception->getErrors();
            self::assertCount(1, $errors);
            self::assertSame('Duplicate organism found at position (x:2, y:2).', $errors[0]->getMessage());
        }
    }
}
