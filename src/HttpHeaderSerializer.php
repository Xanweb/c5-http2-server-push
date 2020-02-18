<?php
/**
 * Adapted and included from Symfony WebLink Component.
 */
namespace Xanweb\ServerPush;

use Psr\Link\LinkInterface;

final class HttpHeaderSerializer
{
    /**
     * Builds the value of the "Link" HTTP header.
     *
     * @param LinkInterface[]|\Traversable $links
     *
     * @return string|null
     */
    public function serialize(iterable $links): ?string
    {
        $elements = [];
        foreach ($links as $link) {
            if ($link->isTemplated()) {
                continue;
            }

            $attributesParts = ['', sprintf('rel="%s"', implode(' ', $link->getRels()))];
            foreach ($link->getAttributes() as $key => $value) {
                if (\is_array($value)) {
                    foreach ($value as $v) {
                        $attributesParts[] = sprintf('%s="%s"', $key, $v);
                    }

                    continue;
                }

                if (!\is_bool($value)) {
                    $attributesParts[] = sprintf('%s="%s"', $key, $value);

                    continue;
                }

                if (true === $value) {
                    $attributesParts[] = $key;
                }
            }

            $elements[] = sprintf('<%s>%s', $link->getHref(), implode('; ', $attributesParts));
        }

        return $elements ? implode(',', $elements) : null;
    }
}
