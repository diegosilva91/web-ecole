<?php

namespace App\Http\Controllers\Api\Teachers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lifecole\Api\Application\Users\GetUsersWithTeacherRole\GetUsersWithTeacherRoleIsFeaturedQuery;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Event\Domain\Bus\Query\QueryBus;

class GetUsersWithTeacherRoleIsFeaturedController extends Controller
{
    public function getTeachers(Request $request, CdnAdapter $cdnAdapter, QueryBus $queryBus)
    {
        $is_featured = $request->get('is_featured') === 'true';
        $teachers = $queryBus->ask(new GetUsersWithTeacherRoleIsFeaturedQuery($is_featured));

        $response = [];
        for ($i = 0; $i < count($teachers); $i += 4) {
            $response[] = array_slice($teachers, $i, 4);
        }

        return response()->json(['teachers' => $response, 'url' => $cdnAdapter->base()]);
    }
}
