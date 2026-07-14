<?php

namespace App\Http\Controllers\Api\FavoritesCourses;

use Auth;
use Illuminate\Http\Request;
use Lifecole\Api\Application\FavoritesCourses\CreateFavoritesCourses\CreateFavoritesCoursesCommand;
use Lifecole\Api\Application\FavoritesCourses\GetFavoritesCoursesQuery\GetFavoritesCoursesQuery;
use Lifecole\Event\Domain\Bus\Command\CommandBus;
use Lifecole\Event\Domain\Bus\Query\QueryBus;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class FavoritesCoursesController
{
    public function __construct(private CommandBus $commandBus, private QueryBus $queryBus)
    {
    }

    public function create(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([], 201);
        }

        if (isset($request->course_id)) {
            $createFavoritesCoursesCommand = new CreateFavoritesCoursesCommand($request->course_id, Auth::id());
            $this->commandBus->dispatch($createFavoritesCoursesCommand);
            return response()->json([], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'errors' => 'Error creando favorito'
            ], 422);
        }
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Error eliminando favorito'
            ], 422);
        }

        if (isset($request->course_id)) {
            $favouritesCourse = \App\FavouritesCourses::where(['user_id' => Auth::id(), 'course_id' => $request->course_id])->first();
            if ($favouritesCourse) {
                $favouritesCourse->delete();
            }
            return response()->json('Borrado');
        } else {
            return response()->json([
                'status' => 'error',
                'errors' => 'Error eliminando favorito'
            ], 422);
        }
    }

    public function isFavorite(Request $request, $course_id)
    {
        if (!Auth::check()) {
            return response()->json(false);
        }

        if (isset($course_id)) {
            $favouritesCourse = $this->queryBus->ask(
                new GetFavoritesCoursesQuery(CourseId::create($course_id), UserId::create(Auth::id()))
            );
            if (isset($favouritesCourse)) {
                return response()->json(true);
            }
        }
        return response()->json(false);
    }
}
