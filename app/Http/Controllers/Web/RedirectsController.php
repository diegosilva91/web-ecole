<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Courses\CoursesController;
use App\Mail\Internal\ReportCommandError;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Mi-empresa\Api\Application\Courses\GetOldCourse\GetOldCourseQuery;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class RedirectsController extends Controller
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function trajectoriesCode()
    {
        return redirect('/es/cursos/s/area-informatica-programacion-y-sistemas/categoria-programacion');
    }

    public function trajectoriesGame()
    {
        return redirect('/es/cursos/s/area-informatica-programacion-y-sistemas/categoria-creacion-de-videojuegos');
    }

    public function trajectoriesRobot()
    {
        return redirect('/es/cursos');
    }

    public function trajectoriesDigitalArt()
    {
        return redirect('/es/cursos');
    }

    public function trajectoriesRs()
    {
        return redirect('/es/cursos');
    }

    public function oldCourseUrl($category, $slug): RedirectResponse
    {
        $course = $this->queryBus->ask(new GetOldCourseQuery($slug, $category));
        if (!$course) {
            return redirect()->route('courses.list')->setStatusCode(301);
        }
        if (empty($course->specialization())) {
            abort(410);
        }
        if (empty($course->category())) {
            abort(410);
        }
        try {
            throw new \Exception("Visit old url");
        } catch (\Exception $exception) {
            try {
                $referer = $_SERVER['HTTP_REFERER'] ?? '';
                Mail::send(new ReportCommandError(static::class, [
                    'course_id' => optional($course->first())->id,
                    'title' => optional($course->first())->title,
                    'slug_category' => $category,
                    'slug' => $slug,
                    'referer' => $referer
                ], $exception));
            } catch (\Throwable $throwableToIgnore) {
            }
        }
        return redirect()->action([ CoursesController::class, 'courseNew' ], [
            'specialization' => $course->specialization()->slug, 'category' => $course->categoryNew()->slug, 'slug' => $slug
        ]);
    }
}
