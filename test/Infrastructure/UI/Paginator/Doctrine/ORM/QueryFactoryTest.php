<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class QueryFactoryTest extends TestCase
{
    /** @var Query */
    private $query;

    public function setUp()
    {
        $this->query = new Query(new FakeEntityManager());
    }

    public function testOffsetForSecondPage()
    {
        self::assertEquals(
            10,
            $this->buildQuery(2, 10)->getFirstResult()
        );
    }

    public function testOffsetForNinePage()
    {
        self::assertEquals(
            120,
            $this->buildQuery(9, 15)->getFirstResult()
        );
    }

    public function testLimit()
    {
        self::assertEquals(6, $this->buildQuery(3, 6)->getMaxResults());
    }

    private function buildQuery(int $page, int $limit) : Query
    {
        return (new QueryFactory())->build($this->query, new Page($page), new QueryLimit($limit));
    }
}
