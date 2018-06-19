<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryOffset;
use PHPUnit\Framework\TestCase;

class QueryFactoryTest extends TestCase
{
    /** @var Page */
    private $page;
    /** @var QueryLimit */
    private $limit;
    /** @var Query */
    private $query;

    public function setUp()
    {
        $this->page = new Page(2);
        $this->limit = new QueryLimit(13);
        $this->query = $this->buildQuery($this->page, $this->limit);
    }

    public function testGetFirstResult()
    {
        self::assertEquals(
            $this->buildOffset($this->page, $this->limit)->toNumber(),
            $this->query->getFirstResult()
        );
    }

    public function testGetMaxResult()
    {
        self::assertEquals($this->limit->toNumber(), $this->query->getMaxResults());
    }

    private function buildQuery(Page $page, QueryLimit $limit) : Query
    {
        return (new QueryFactory())->build(
            new Query(
                new FakeEntityManager()
            ),
            $page,
            $limit
        );
    }

    private function buildOffset(Page $page, QueryLimit $limit) : QueryOffset
    {
        return new QueryOffset($page, $limit);
    }
}
