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
    public function testBuild()
    {
        $query = new Query(new FakeEntityManager());
        $page = new Page(2);
        $limit = new QueryLimit(13);
        $query->setFirstResult($this->buildOffset($page, $limit)->toNumber());
        $query->setMaxResults($limit->toNumber());
        self::assertEquals($query, $this->buildQuery($page, $limit));
    }

    private function buildOffset(Page $page, QueryLimit $limit) : QueryOffset
    {
        return new QueryOffset($page, $limit);
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
