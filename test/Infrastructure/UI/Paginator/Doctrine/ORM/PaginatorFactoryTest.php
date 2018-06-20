<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure\UI\Paginator\Doctrine\ORM;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Landingi\Fake\FakeEntityManager;
use Landingi\Shared\Infrastructure\UI\Paginator\Page;
use Landingi\Shared\Infrastructure\UI\Paginator\Query\QueryLimit;
use PHPUnit\Framework\TestCase;

class PaginatorFactoryTest extends TestCase
{
    public function testBuild()
    {
        $paginator = new Paginator(
            $query = $this->buildQuery(
                $page = new Page(2),
                $limit = new QueryLimit(12)
            ),
            false
        );
        self::assertEquals($paginator, (new PaginatorFactory(new QueryFactory()))->build(
            $query,
            $page,
            $limit
        ));
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
