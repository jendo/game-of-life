<?php

declare(strict_types=1);

namespace AppTests\Unit\Game\Input;

use App\Game\Input\Life;
use App\Game\Input\LifeInputSerializer;
use App\Game\Input\LifeInputProcessor;
use App\Game\Input\Validation\InvalidStateException;
use App\Game\Input\Validation\LifeStateValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class LifeInputProcessorTest extends TestCase
{
    private MockObject $lifeInputSerializer;

    private MockObject $lifeStateValidator;

    private LifeInputProcessor $lifeInputProcessor;

    protected function setUp(): void
    {
        $this->lifeInputSerializer = $this->createMock(LifeInputSerializer::class);
        $this->lifeStateValidator = $this->createMock(LifeStateValidator::class);

        $this->lifeInputProcessor = new LifeInputProcessor(
            $this->lifeInputSerializer,
            $this->lifeStateValidator
        );
    }

    public function testProcess(): void
    {
        $xmlData = '<life><world><cells>10</cells><iterations>5</iterations></world><organisms><organism><x_pos>1</x_pos><y_pos>2</y_pos></organism></organisms></life>';
        $life = $this->createMock(Life::class);

        $this->lifeInputSerializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData)
            ->willReturn($life);

        $this->lifeStateValidator
            ->expects(self::once())
            ->method('validate')
            ->with($life);

        $result = $this->lifeInputProcessor->process($xmlData);

        self::assertSame($life, $result);
    }

    public function testProcessThrowsValidationFailedException(): void
    {
        $xmlData = '<life><world><cells>10</cells><iterations>5</iterations></world><organisms><organism><x_pos>1</x_pos><y_pos>2</y_pos></organism></organisms></life>';
        $life = $this->createMock(Life::class);

        $this->lifeInputSerializer
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData)
            ->willReturn($life);

        $this->lifeStateValidator
            ->expects(self::once())
            ->method('validate')
            ->with($life)
            ->willThrowException(new InvalidStateException('Invalid state'));

        $this->expectException(InvalidStateException::class);

        $this->lifeInputProcessor->process($xmlData);
    }
}
