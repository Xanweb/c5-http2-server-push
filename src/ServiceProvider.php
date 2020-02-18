<?php
namespace Xanweb\ServerPush;

use Concrete\Core\Foundation\Service\Provider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->app->singleton([HttpPush::class => 'http2/server-push']);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return ['http2/server-push'];
    }
}
