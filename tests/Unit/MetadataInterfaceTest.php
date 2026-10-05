<?php

declare(strict_types=1);

namespace ContenirTest\Metadata\Unit;

use Contenir\Metadata\MetadataInterface;
use ContenirTest\Metadata\TestAsset\PageMetadata;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use ReflectionNamedType;

#[CoversNothing]
#[Group('unit')]
final class MetadataInterfaceTest extends TestCase
{
    /**
     * @return array<string, array{non-empty-string, non-empty-string}>
     */
    public static function getterProvider(): array
    {
        return [
            'title'         => ['getMetaTitle', 'string'],
            'description'   => ['getMetaDescription', 'string'],
            'image'         => ['getMetaImage', 'string'],
            'modified date' => ['getMetaModified', DateTimeInterface::class],
            'publish date'  => ['getMetaPublish', DateTimeInterface::class],
        ];
    }

    /**
     * @param non-empty-string $method
     */
    #[Test]
    #[DataProvider('getterProvider')]
    public function getterDeclaresNullableNativeReturnType(string $method, string $type): void
    {
        $returnType = (new ReflectionMethod(MetadataInterface::class, $method))->getReturnType();

        static::assertInstanceOf(ReflectionNamedType::class, $returnType);
        static::assertSame([$type, true], [$returnType->getName(), $returnType->allowsNull()]);
    }

    /**
     * @param non-empty-string $method
     */
    #[Test]
    #[DataProvider('getterProvider')]
    public function getterTakesNoParameters(string $method): void
    {
        static::assertSame(0, (new ReflectionMethod(MetadataInterface::class, $method))->getNumberOfParameters());
    }

    #[Test]
    public function implementerMayLeaveEveryValueUnset(): void
    {
        $metadata = new PageMetadata();

        static::assertSame(
            [null, null, null, null, null],
            [
                $metadata->getMetaTitle(),
                $metadata->getMetaDescription(),
                $metadata->getMetaImage(),
                $metadata->getMetaModified(),
                $metadata->getMetaPublish(),
            ],
        );
    }

    #[Test]
    public function implementerReturnsTheMetadataItWasGiven(): void
    {
        $modified = new DateTimeImmutable('2026-01-02 03:04:05');
        $publish  = new DateTimeImmutable('2026-01-01 00:00:00');
        $metadata = new PageMetadata(
            title: 'About us',
            description: '<p>Who we are</p>',
            image: 'asset/page/about.jpg',
            modified: $modified,
            publish: $publish,
        );

        static::assertSame(
            ['About us', '<p>Who we are</p>', 'asset/page/about.jpg', $modified, $publish],
            [
                $metadata->getMetaTitle(),
                $metadata->getMetaDescription(),
                $metadata->getMetaImage(),
                $metadata->getMetaModified(),
                $metadata->getMetaPublish(),
            ],
        );
    }
}
