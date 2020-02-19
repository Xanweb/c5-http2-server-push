<?php
namespace Xanweb\ServerPush;

use Fig\Link\LinkProviderTrait;
use Psr\Link\LinkProviderInterface;
use Psr\Link\LinkInterface;

class HttpPush implements LinkProviderInterface
{
    use LinkProviderTrait;

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
