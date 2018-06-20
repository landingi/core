<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Factory;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM\QueryFactory;
use Landingi\Shared\Infrastructure\UI\Paginator\DoctrinePaginator;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class DoctrinePaginatorFactoryTest extends TestCase
{
    /** @var QueryFactory */
    private $queryFactory;

    public function setUp()
    {
        $this->queryFactory = new QueryFactory();
    }

    public function testBuild()
    {
        $page = new Page(3);
        $limit = new QueryLimit(4);
        $query = new Query(new FakeEntityManager());

        $doctrinePaginator = new DoctrinePaginator($this->getOrmPaginator($query, $page, $limit), $page);
        self::assertEquals(
            $doctrinePaginator,
            (new DoctrinePaginatorFactory($this->queryFactory))->build($query, $page, $limit)
        );
    }

    private function getOrmPaginator(Query $query, Page $page, QueryLimit $limit) : Paginator
    {
        return new Paginator(
            $this->queryFactory->build(
                $query,
                $page,
                $limit
            ),
            false
        );
    }
}
