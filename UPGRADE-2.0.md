# Upgrading from 1.x to 2.0

2.0 adds native return types to `MetadataInterface` and moves to PHP 8.3+.
Callers of the interface need no changes; classes that **implement** it must
declare the new return types.

| | 1.x | 2.0 |
| --- | --- | --- |
| PHP | ^8.0 | 8.3, 8.4 or 8.5 |
| `laminas/laminas-mvc` | required (unused) | not required |

```bash
composer require contenir/contenir-metadata:^2.0
```

## BC break: native return types on the string getters

`getMetaTitle()`, `getMetaDescription()` and `getMetaImage()` had no native
return type in 1.x. In 2.0 they return `?string`. An implementation without
a return type, or with an incompatible one, is now a fatal error:

```text
Declaration of Page::getMetaTitle() must be compatible with
Contenir\Metadata\MetadataInterface::getMetaTitle(): ?string
```

Before (1.x):

```php
final class Page implements MetadataInterface
{
    public function getMetaTitle()
    {
        return $this->title;
    }

    public function getMetaDescription()
    {
        return $this->description;
    }

    public function getMetaImage()
    {
        return $this->image;
    }

    public function getMetaModified(): ?DateTimeInterface { /* … */ }

    public function getMetaPublish(): ?DateTimeInterface { /* … */ }
}
```

After (2.0):

```php
final class Page implements MetadataInterface
{
    public function getMetaTitle(): ?string
    {
        return $this->title;
    }

    public function getMetaDescription(): ?string
    {
        return $this->description;
    }

    public function getMetaImage(): ?string
    {
        return $this->image;
    }

    public function getMetaModified(): ?DateTimeInterface { /* … */ }

    public function getMetaPublish(): ?DateTimeInterface { /* … */ }
}
```

Notes:

- Declaring the narrower `string` (non-nullable) in an implementation is also
  valid, since return types are covariant.
- Return `null`, not `''` or `false`, when a value is not set. Under
  `strict_types`, returning a non-string (for example an `int` id or an asset
  object for the image) is now a `TypeError`; return the asset's path instead.
- Implementations that already declared `?string`, such as
  `contenir/contenir-resource`'s `BaseResourceEntity`, need no change.

## Not a break: date getters

`getMetaModified()` and `getMetaPublish()` keep their `?DateTimeInterface`
native return types. Only their docblocks changed, from an incorrect
`@return string` to the declared type. Static analysers that trusted the old
docblock will now see the correct type.

## Removed dependency

1.x required `laminas/laminas-mvc` without using it. If your project uses
laminas-mvc and relied on this package to pull it in, add it to your own
`composer.json`.

Projects that must stay on PHP 8.0 to 8.2 can keep using `^1.0`, which is
maintained on the `1.x` branch.
