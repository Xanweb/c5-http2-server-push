<?php
namespace Xanweb\ServerPush\Middleware;

use Concrete\Core\Page\Page;
use Concrete\Core\Http\RequestBase;
use Concrete\Core\Http\Middleware\DelegateInterface;
use Concrete\Core\Http\Middleware\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Xanweb\ServerPush\HttpHeaderSerializer;
use Xanweb\ServerPush\HttpPush;

class Http2ServerPushMiddleware implements MiddlewareInterface
{
    private $serializer;
    /**
     * @var HttpPush
     */
    private $httpPush;

    /**
     * Http2ServerPushMiddleware constructor.
     *
     * @param HttpPush $httpPush
     */
    public function __construct(HttpPush $httpPush)
    {
        $this->serializer = new HttpHeaderSerializer();
        $this->httpPush = $httpPush;
    }

    /**
     * @param Request $request
     * @param \Concrete\Core\Http\Middleware\DelegateInterface $frame
     *
     * @return Response
     */
    public function process(Request $request, DelegateInterface $frame)
    {
        $response = $frame->next($request);

        if ($this->shouldPushLinkHeader($request)) {
            $response->headers->set('Link', $this->serializer->serialize($this->httpPush->getLinks()), false);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function shouldPushLinkHeader(Request $request): bool
    {
        return $request instanceof RequestBase && $request->getCurrentPage() instanceof Page && $this->httpPush->hasLinks();
    }
}
