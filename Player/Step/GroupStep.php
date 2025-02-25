<?php

/*
 * This file is part of the Blackfire Player package.
 *
 * (c) Fabien Potencier <fabien@blackfire.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blackfire\Player\Step;

/**
 * @author Fabien Potencier <fabien@blackfire.io>
 *
 * @internal
 */
class GroupStep extends BlockStep
{
    public function __construct(
        private readonly string|null $key,
        string|null $file = null,
        int|null $line = null,
    ) {
        parent::__construct($file, $line);
    }

    public function getKey(): string|null
    {
        return $this->key;
    }
}
