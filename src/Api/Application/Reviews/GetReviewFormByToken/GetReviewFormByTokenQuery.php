<?php

namespace Mi-empresa\Api\Application\Reviews\GetReviewFormByToken;

use Mi-empresa\Event\Domain\Bus\Query\Query;

class GetReviewFormByTokenQuery extends Query
{
    public function __construct(private string $token)
    {
        parent::__construct();
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
