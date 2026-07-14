<?php

namespace App\Http\Controllers\Web\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseURLRequest;
use App\Http\Requests\CourseURLSearchRequest;
use App\Mail\Internal\ReportCommandError;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Lifecole\Api\Application\CourseHistoricalViewed\AddCourseHistoricalView\AddCourseHistoricalViewedCommand;
use Lifecole\Api\Application\Courses\GetCourse\GetCourseQuery;
use Lifecole\Api\Application\Menu\GetElementsFromMenuQuery;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Api\Domain\DTO\MenuTreeSelector;
use Lifecole\Api\Domain\Helper\AddPriceHour;
use Lifecole\Api\Domain\Helper\AddTeachers;
use Lifecole\Event\Domain\Bus\Command\CommandBus;
use Lifecole\Event\Domain\Bus\Query\QueryBus;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class CoursesController extends Controller
{
    public function __construct(private QueryBus $queryBus, private CommandBus $commandBus)
    {
    }

    public function searchAnyCourses(
        CourseURLSearchRequest $request
    ): \Illuminate\Http\Response {
        $parameters = [];

        if (!empty($request->category)) {
            $parameters [ 'category' ] = $request->category;
        }
        if (!empty($request->specialization)) {
            $parameters [ 'specialization' ] = $request->specialization;
        }
        if (!empty($request->area)) {
            $parameters [ 'area' ] = $request->area;
        }
        if (!empty($request->age)) {
            $parameters [ 'age' ] = $request->age;
        }
        if (!empty($request->search)) {
            $parameters [ 'search' ] = $request->search;
        }
        if (!empty($request->tag)) {
            $parameters [ 'tag' ] = $request->tag;
        }

        $request = Request::create(route('courses.list', $parameters));
        return Response::make($this->courses($request));
    }

    public function courses(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $courseDTO = CoursesSearch::createFromRequest(
            $request->get('type_course', Course::TYPE_INTENSIVE),
            $request->get('area'),
            $request->get('category'),
            $request->get('specialization'),
            $request->get('tag'),
            $request->get('age'),
            $request->get('search'),
            1,
            6
        );
        $treeFilters = $this->queryBus->ask(new GetElementsFromMenuQuery(
            MenuTreeSelector::createFromRequest(MenuTreeSelector::TREE_NEEDS),
            $courseDTO
        ));
        return view('pages.courses', [
            'treeFilters' => $treeFilters
        ]);
    }

    public function courseNew(
        CourseURLRequest $request,
        $category,
        $specialization,
        $slug,
        CdnAdapter $cdnAdapter,
        AddPriceHour $addPriceHour,
        AddTeachers $addTeachers
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse {
        $userId = Auth::check() ? UserId::create(Auth::id()) : null;
        $visible = !isset($request->preview) || !$request->preview;
        $course = $this->queryBus->ask(new GetCourseQuery($specialization, $category, $slug, $visible));

        if (!$course) {
            return redirect()->route('courses.list')->setStatusCode(301);
        }

        if (Auth::check()) {
            $this->commandBus->dispatch(new AddCourseHistoricalViewedCommand($userId, CourseId::create($course->id)));
        }

        $promotions = $course->promotions()->IsPurchasable(true)->ActivePromotions(true)->cursor();
        $promotions = $promotions->filter(function ($promotion) {
            if (isset($promotion->courses) && isset($promotion->promotionPurchases)) {
                return $promotion->courses->students_max > $promotion->promotionPurchases->count();
            }
        });

        $addPriceHour->apply($course);
        $addTeachers->apply($course);
        if ($course->is_subscription === 1) {
            $course->load('pricesPacks');
            $course->load('pricesEnrollment');
            $course->load('faqs');
            if (count($course->pricesEnrollment) > 0) {
                $course->price_enrollment = $course->pricesEnrollment->first();
            } else {
                $course->price_enrollment = 0;
            }
        }

        $baseUrl = $cdnAdapter->base();
        $next_months = [];
        for ($i = 0; $i < 6; $i++) {
            $next_months[] = [ 'date' => Carbon::now()->addMonths($i)->startOfMonth()->toDateString() . ',' . Carbon::now()->addMonths($i)->endOfMonth()->toDateString(),
                'name' => Str::ucfirst(Carbon::now()->addMonths($i)->locale('es')->monthName)
            ];
        }

        $teachers = $course->getCourseUsers()->all();
        foreach ($teachers as $teacher) {
            $teacher['bio'] = $teacher->teacher()->first()->bio;
            $teacher['title'] = $teacher->teacher()->first()->title;
        }

        return view('pages.course', [ "course" => $course, "promotions" => $promotions,
            "url" => $baseUrl, "next_months" => $next_months, "teachers" => $teachers
        ]);
    }
}
