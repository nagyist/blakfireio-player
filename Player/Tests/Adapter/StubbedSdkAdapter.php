<?php

/*
 * This file is part of the Blackfire Player package.
 *
 * (c) Fabien Potencier <fabien@blackfire.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blackfire\Player\Tests\Adapter;

use Blackfire\ClientConfiguration;
use Blackfire\Player\Adapter\BlackfireSdkAdapterInterface;
use Blackfire\Player\Build\Build;
use Blackfire\Profile;
use Blackfire\Profile\Configuration;
use Blackfire\Profile\Request;

class StubbedSdkAdapter implements BlackfireSdkAdapterInterface
{
    public function __construct(private readonly string $envName, private readonly Profile|\Closure|null $profileFactory = null)
    {
    }

    public function getConfiguration(): ClientConfiguration
    {
        $conf = new ClientConfiguration();
        $conf->setEnv($this->envName);

        return $conf;
    }

    public function createRequest(string|Configuration|null $config = null): Request
    {
        return new Request($config, [
            'query_string' => 'foo=bar',
            'uuid' => '9ce3d913-1337-4635-1337-af8a91451e30',
        ]);
    }

    public function updateProfile(string $uuid, string $title, array|null $metadata = null): bool
    {
        return true;
    }

    public function getProfile(string $uuid): Profile
    {
        if ($this->profileFactory instanceof Profile) {
            return $this->profileFactory;
        }

        if (\is_callable($this->profileFactory)) {
            return ($this->profileFactory)($uuid);
        }

        return new Profile(fn (): array => [
            'report' => [
                'state' => 'successful',
            ],
            '_links' => [
                'graph_url' => [
                    'href' => \sprintf('https://app.blackfire.io/profiles/%s/graph', $uuid),
                ],
            ],
        ], $uuid);
    }

    public function startBuild(string|null $env = null, array $options = []): Build
    {
        return new Build('4444-3333-2222-1111');
    }
}
