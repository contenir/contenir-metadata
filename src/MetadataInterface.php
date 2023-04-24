<?php

namespace Contenir\Metadata;

use DateTimeInterface;

interface MetadataInterface
{
    /**
     * @return string
     */
    public function getMetaTitle();

    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @return string
     */
    public function getMetaImage();

    /**
     * @return string
     */
    public function getMetaModified(): ?DateTimeInterface;

    /**
     * @return string
     */
    public function getMetaPublish(): ?DateTimeInterface;
}
