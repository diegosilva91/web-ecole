<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Lifecole\Api\Application\Users\GetUsersProfile\GetUsersProfileQuery;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Event\Domain\Bus\Query\QueryBus;
use Lifecole\Shared\Domain\ValueObject\UserId;

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
