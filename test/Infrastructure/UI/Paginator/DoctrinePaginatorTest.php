<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class DoctrinePaginatorTest extends TestCase
{
    /** @var OrmPaginator */
    private $ormPaginator;

    /** @var Page */
    private $page;

    /**
     * @var QueryLimit
     */
    private $limit;

    public function setUp()
    {
        $this->ormPaginator = $this->prophesize(OrmPaginator::class);
        $this->ormPaginator->getQuery()->willReturn($this->buildQuery());
        $this->page = new Page(3);
        $this->limit = new QueryLimit(10);
    }

    public function testGetItems()
    {
        $results = ['foo', 'bar'];
        $this->ormPaginator->getIterator()->willReturn($results);

        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page,
            $this->limit
        );
        self::assertCount(\count($results), $doctrinePaginator->getItems());
    }

    public function testCount()
    {
        $this->ormPaginator->count()->willReturn($this->limit->toNumber());
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page,
            $this->limit
        );
        self::assertEquals($this->limit->toNumber(), $doctrinePaginator->count());
    }

    public function testGetPage()
    {
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page,
            $this->limit
        );
        self::assertEquals($this->page, $doctrinePaginator->getPage());
    }

    public function testGetLimit()
    {
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page,
            $this->limit
        );
        self::assertEquals(10, $doctrinePaginator->getLimit());
    }

    private function buildQuery() : Query
    {
        return new Query(
            new FakeEntityManager()
        );
    }
}
