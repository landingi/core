<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Factory\OrmQueryFactory;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class DoctrinePaginatorTest extends TestCase
{
    /** @var OrmPaginator */
    private $ormPaginator;

    /** @var Page */
    private $page;

    public function setUp()
    {
        $this->ormPaginator = $this->prophesize(OrmPaginator::class);
        $this->page = new Page(3);
    }

    public function testGetItems()
    {
        $results = ['foo', 'bar'];
        $this->ormPaginator->getIterator()->willReturn($results);

        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertCount(\count($results), $doctrinePaginator->getItems());
    }

    public function testCount()
    {
        $this->ormPaginator->count()->willReturn(20);
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertEquals(20, $doctrinePaginator->count());
    }

    public function testGetPage()
    {
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertEquals($this->page, $doctrinePaginator->getPage());
    }

    public function testGetLimit()
    {
        $this->ormPaginator->getQuery()->willReturn(
            $this->buildQuery(
                new Page(3),
                new QueryLimit($limit = 12)
            )
        );
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertEquals($limit, $doctrinePaginator->getLimit());
    }

    private function buildQuery(Page $page, QueryLimit $limit) : Query
    {
        return (new OrmQueryFactory(
            new Query(
                new FakeEntityManager()
            ),
            $page,
            $limit
        ))->buildQueryWithDelimeters();
    }
}
