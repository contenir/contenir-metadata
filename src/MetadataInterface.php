<?php

declare(strict_types=1);

namespace Contenir\Metadata;

use DateTimeInterface;

/**
 * Page metadata exposed by a resource: what a page's <title>, description,
 * Open Graph/Twitter tags and sitemap <lastmod> are built from.
 *
 * Every getter may return null, meaning "not set": consumers skip the
 * corresponding tag rather than emitting an empty one.
 *
 * @api
 */
interface MetadataInterface
{
    /**
     * Page description, used for the description, og:description and
     * twitter:description meta tags. May contain markup; consumers strip it.
     */
    public function getMetaDescription(): ?string;

    /**
     * Path or identifier of the page's share image, resolved to a URL by the
     * consumer (for example the Asset view helper) for og:image and twitter:image.
     */
    public function getMetaImage(): ?string;

    /**
     * When the page was last modified, used for sitemap <lastmod> and as the
     * og:updated_time fallback when no publish date is set.
     */
    public function getMetaModified(): ?DateTimeInterface;

    /**
     * When the page was published, preferred over the modified date for
     * og:updated_time.
     */
    public function getMetaPublish(): ?DateTimeInterface;

    /**
     * Page title, used for <title>, og:title and twitter:title.
     */
    public function getMetaTitle(): ?string;
}
