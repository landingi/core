<?php
declare(strict_types=1);

namespace Landingi\Shared\Infrastructure;

class UrlQuery
{
    private $params;

    public static function fromString(string $query) : UrlQuery
    {
        return new self(array_reduce(
            explode('&', $query),
            function ($carry, $partial) {
                if (count(explode('=', $partial, 2)) === 2) {
                    [$name, $value] = explode('=', $partial, 2);
                    $carry[$name] = $value;
                }

                return $carry;
            },
            []
        ));
    }

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __toString()
    {
        return http_build_query($this->params);
    }

    public function with(string $param, string $value) : UrlQuery
    {
        $query = clone $this;
        $query->params[$param] = $value;

        return $query;
    }
}
