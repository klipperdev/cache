<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Cache\Tests\Adapter;

use Klipper\Component\Cache\Adapter\CouchbaseBucketAdapter;
use PHPUnit\Framework\SkippedTestSuiteError;

/**
 * Couchbase Bucket Adapter Test.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @internal
 */
final class CouchbaseBucketAdapterTest extends AbstractAdapterTest
{
    public static function setupBeforeClass(): void
    {
        if (!CouchbaseBucketAdapter::isSupported()) {
            throw new SkippedTestSuiteError('Couchbase >= 2.6.0 < 3.0.0 is required.');
        }
    }

    protected function setUp(): void
    {
        $couchbase = CouchbaseBucketAdapter::createConnection('couchbase://'.getenv('COUCHBASE_HOST').'/cache',
            ['username' => getenv('COUCHBASE_USER'), 'password' => getenv('COUCHBASE_PASS')]
        );

        static::assertInstanceOf(\CouchbaseBucket::class, $couchbase);

        $this->adapter = new CouchbaseBucketAdapter($couchbase, static::PREFIX_GLOBAL);
        $this->adapter->clear();
    }
}
