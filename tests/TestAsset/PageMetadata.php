<?php

declare(strict_types=1);

namespace ContenirTest\Metadata\TestAsset;

use Contenir\Metadata\MetadataInterface;
use DateTimeInterface;

/**
 * Minimal implementer of the 2.0 contract, as a resource entity would write it.
 */
final readonly class PageMetadata implements MetadataInterface
{
    public function __construct(
        private ?string $title = null,
        private ?string $description = null,
        private ?string $image = null,
        private ?DateTimeInterface $modified = null,
        private ?DateTimeInterface $publish = null,
    ) {}

    public function getMetaDescription(): ?string
    {
        return $this->description;
    }

    public function getMetaImage(): ?string
    {
        return $this->image;
    }

    public function getMetaModified(): ?DateTimeInterface
    {
        return $this->modified;
    }

    public function getMetaPublish(): ?DateTimeInterface
    {
        return $this->publish;
    }

    public function getMetaTitle(): ?string
    {
        return $this->title;
    }
}
