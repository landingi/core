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

    /** @var QueryLimit */
    private $limit;

    public function setUp()
    {
        $this->ormPaginator = $this->prophesize(OrmPaginator::class);
        $this->page = new Page(3);
        $this->limit = new QueryLimit(10);
    }

    public function testGetItems()
    {
        $this->ormPaginator->getIterator()->willReturn(['foo', 'bar']);
        $this->ormPaginator->getQuery()->willReturn($this->buildQuery());

        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
        );
        self::assertCount(2, $doctrinePaginator->getItems());
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
        $ormQuery = $this->buildQuery();
        $ormQuery->setMaxResults(10);
        $this->ormPaginator->getQuery()->willReturn($ormQuery);
        $doctrinePaginator = new DoctrinePaginator(
            $this->ormPaginator->reveal(),
            $this->page
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
