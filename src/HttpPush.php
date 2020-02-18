<?php
namespace Xanweb\ServerPush;

use Psr\Link\LinkProviderInterface;
use Psr\Link\LinkInterface;

class HttpPush implements LinkProviderInterface
{
    /**
     * An array of the links in this provider.
     *
     * The keys of the array MUST be the spl_object_hash() of the object being stored.
     * That helps to ensure uniqueness.
     *
     * @var LinkInterface[]
     */
    private $links = [];

    /**
     * Push link onto the queue for the middleware.
     *
     * @param LinkInterface $link a link object that should be included in this collection
     *
     * @return static
     */
    public function queueLink(LinkInterface $link)
    {
        $this->links[spl_object_id($link)] = $link;

        return $this;
    }

    /**
     * Remove link from the queue.
     *
     * @param LinkInterface $link a link object that should be included in this collection
     *
     * @return static
     */
    public function dequeueLink(LinkInterface $link)
    {
        unset($this->links[spl_object_id($link)]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return array_values($this->links);
    }

    /**
     * {@inheritdoc}
     */
    public function getLinksByRel($rel)
    {
        $filter = function (LinkInterface $link) use ($rel) {
            return in_array($rel, $link->getRels());
        };

        return array_filter($this->links, $filter);
    }

    /**
     * @return bool
     */
    public function hasLinks(): bool
    {
        return !empty($this->links);
    }

    /**
     * Clear all links out of the queue.
     */
    public function clear()
    {
        $this->links = [];
    }
}
