<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Mi-empresa\Api\Application\Users\GetUsersProfile\GetUsersProfileQuery;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class GetUsersProfile extends Controller
{
    public function __construct(private QueryBus $queryBus, private CdnAdapter $cdnAdapter)
    {
    }

    public function getUsersProfile($id)
    {
        $user = $this->queryBus->ask(new GetUsersProfileQuery(UserId::create($id)));
        $url = $this->cdnAdapter->base();
        return response()->json(['user' => $user, 'url' => $url], 200);
    }
}
