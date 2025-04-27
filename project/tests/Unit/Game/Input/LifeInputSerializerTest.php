<?php

declare(strict_types=1);

namespace AppTest\Unit\Game\Input;

use App\Game\Input\Life;
use App\Game\Input\LifeInputSerializer;
use App\Serializer\SerializerWrapper;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class LifeInputSerializerTest extends TestCase
{
    private MockObject $serializerWrapper;

    private LifeInputSerializer $lifeInputSerializer;

    protected function setUp(): void
    {
        $this->serializerWrapper = $this->createMock(SerializerWrapper::class);
        $this->lifeInputSerializer = new LifeInputSerializer($this->serializerWrapper);
    }

    public function testDeserializeWithValidXml(): void
    {
        $xmlData = '<life><world><cells>10</cells><iterations>10</iterations></world></life>';
        $expectedLife = $this->createMock(Life::class);

        $this->serializerWrapper
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData, Life::class, 'xml')
            ->willReturn($expectedLife);

        $result = $this->lifeInputSerializer->deserialize($xmlData);

        self::assertSame($expectedLife, $result);
    }

    public function testDeserializeThrowsInvalidArgumentException(): void
    {
        $xmlData = '<invalid-xml>';
        $this->serializerWrapper
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData, Life::class, 'xml')
            ->willThrowException(new NotEncodableValueException('Invalid XML'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Failed to decode XML data: Invalid XML');

        $this->lifeInputSerializer->deserialize($xmlData);
    }


    public function testDecodeWithEmptyXml(): void
    {
        $xmlData = '';

        $this->serializerWrapper
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData, Life::class, 'xml')
            ->willThrowException(new NotEncodableValueException('No content to decode'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Failed to decode XML data: No content to decode');

        $this->lifeInputSerializer->deserialize($xmlData);
    }

    public function testDecodeWithNonXmlData(): void
    {
        $xmlData = 'This is not XML';

        $this->serializerWrapper
            ->expects(self::once())
            ->method('deserialize')
            ->with($xmlData, Life::class, 'xml')
            ->willThrowException(new NotEncodableValueException('Invalid data format'));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Failed to decode XML data: Invalid data format');

        $this->lifeInputSerializer->deserialize($xmlData);
    }
}
