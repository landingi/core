<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\Paginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\QueryFactory;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
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
        $this->ormPaginator->getIterator()->willReturn(['foo', 'bar']);

        $doctrinePaginator = new Paginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertCount(2, $doctrinePaginator->getItems());
    }

    public function testCount()
    {
        $this->ormPaginator->count()->willReturn(20);
        $doctrinePaginator = new Paginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertEquals(20, $doctrinePaginator->count());
    }

    public function testGetPage()
    {
        $doctrinePaginator = new Paginator(
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
        $doctrinePaginator = new Paginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertEquals($limit, $doctrinePaginator->getLimit());
    }

    public function testGetFirstPage()
    {
        self::assertEquals(new Page(1), (new Paginator($this->ormPaginator->reveal(), $this->page))->getFirstPage());
    }

    public function testGetLastPage()
    {
        $this->ormPaginator->count()->willReturn(30);
        $this->ormPaginator->getQuery()->willReturn(
            $this->buildQuery(
                $this->page,
                new QueryLimit(10)
            )
        );
        self::assertEquals($this->page, (new Paginator($this->ormPaginator->reveal(), $this->page))->getLastPage());
    }

    public function testOnFirstPage()
    {
        self::assertTrue((new Paginator($this->ormPaginator->reveal(), new Page(1)))->onFirstPage());
    }

    public function testNotOnFirstPage()
    {
        self::assertFalse((new Paginator($this->ormPaginator->reveal(), $this->page))->onFirstPage());
    }

    public function testOnLastPage()
    {
        $this->ormPaginator->count()->willReturn(30);
        $this->ormPaginator->getQuery()->willReturn(
            $this->buildQuery(
                $this->page,
                new QueryLimit(10)
            )
        );
        $doctrinePaginator = new Paginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertTrue($doctrinePaginator->onLastPage());
    }

    public function testNotOnLastPage()
    {
        $this->ormPaginator->count()->willReturn(40);
        $this->ormPaginator->getQuery()->willReturn(
            $this->buildQuery(
                $this->page,
                new QueryLimit(10)
            )
        );
        $doctrinePaginator = new Paginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertFalse($doctrinePaginator->onLastPage());
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
}
