# contenir/contenir-metadata

[![Continuous Integration](https://github.com/contenir/contenir-metadata/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/contenir/contenir-metadata/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/contenir/contenir-metadata/graph/badge.svg)](https://codecov.io/gh/contenir/contenir-metadata)

The page metadata contract for [Contenir CMS](https://github.com/contenir).

`Contenir\Metadata\MetadataInterface` is implemented by resource entities
(for example `contenir/contenir-resource`'s `BaseResourceEntity`) and read by
the packages that render a page's head and sitemap:

- `contenir/contenir-resource`'s `ResourceMeta` view helper builds `<title>`,
  the description meta tag, Open Graph and Twitter tags from it.
- `contenir/contenir-mvc-workflow`'s `ResourceStrategy` uses the modified date
  as the navigation page's sitemap `lastmod`.

The package contains only the interface and has no runtime dependencies.

## Requirements

PHP 8.3, 8.4 or 8.5. The 1.x releases, which support PHP 8.0+, remain
available from the `1.x` branch and `v1.*` tags; see [UPGRADE-2.0.md](UPGRADE-2.0.md).

## Install

```bash
composer require contenir/contenir-metadata
```

## Usage

Implement the interface on whatever represents a page:

```php
use Contenir\Metadata\MetadataInterface;
use DateTimeImmutable;
use DateTimeInterface;

final class Page implements MetadataInterface
{
    public function __construct(
        private string $title,
        private ?string $metaTitle = null,
        private ?string $metaDescription = null,
        private ?string $imagePath = null,
        private ?string $updated = null,
        private ?string $created = null,
    ) {}

    public function getMetaTitle(): ?string
    {
        return $this->metaTitle ?? $this->title;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function getMetaImage(): ?string
    {
        return $this->imagePath;
    }

    public function getMetaModified(): ?DateTimeInterface
    {
        return $this->updated !== null ? new DateTimeImmutable($this->updated) : null;
    }

    public function getMetaPublish(): ?DateTimeInterface
    {
        return $this->created !== null ? new DateTimeImmutable($this->created) : null;
    }
}
```

| Method | Returns | Used for |
| --- | --- | --- |
| `getMetaTitle()` | `?string` | `<title>`, `og:title`, `twitter:title` |
| `getMetaDescription()` | `?string` | `description`, `og:description`, `twitter:description` (markup is stripped by the consumer) |
| `getMetaImage()` | `?string` | Asset path resolved to `og:image` and `twitter:image` |
| `getMetaModified()` | `?DateTimeInterface` | Sitemap `lastmod`; `og:updated_time` when no publish date is set |
| `getMetaPublish()` | `?DateTimeInterface` | `og:updated_time` (preferred over the modified date) |

Return `null` for anything the page does not have. Consumers treat `null` as
"not set" and leave the corresponding tag out.

## Configuration

None. The package registers no services.

## Development

The QA toolchain is [php-db/phpdb-qa-tools](https://github.com/php-db/phpdb-qa-tools).
[Mago](https://mago.carthage.software/) is a standalone binary, installed
separately (`brew install mago`).

```bash
composer check             # everything below
composer cs-check          # mago format --check && mago lint
composer static-analysis   # mago analyze
composer test              # unit suite: the interface contract, via tests/TestAsset/PageMetadata
composer test-integration  # integration suite: empty, the package performs no I/O
composer test-coverage     # both suites, clover.xml for Codecov
```

## License

BSD-3-Clause. See [LICENSE.md](LICENSE.md).
