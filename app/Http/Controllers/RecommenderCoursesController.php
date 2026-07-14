<?php

namespace App\Http\Controllers;

use App\CourseRecommender;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class RecommenderCoursesController extends Controller
{
    public const DAYS = [
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
        "Domingo",
        "Cualquier Horario"
    ];

    public function __construct()
    {
        $this->middleware('auth')->except(['showTypeForm', 'update', 'fetchCourseData', 'webhooks', 'index']);
    }

    public function showTypeForm()
    {
        $form_id = 'cjtVJFh6';
        return view('pages.recommenderTypeform', ['form_id' => $form_id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request_recommender = $request->toArray();
        $course_recommender = CourseRecommender::when(Arr::has($request_recommender, 'user_id'), function ($query) use ($request_recommender) {
            return $query->where('user_id', $request_recommender['user_id']);
        })
            ->when(Arr::has($request_recommender, 'id'), function ($query) use ($request_recommender) {
                return $query->where('id', $request_recommender['id'])->orWhere('u_key', $request_recommender['id']);
            })
            ->get()->last();
        return response()->json($course_recommender);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $token_typeform = $request->get('token_typeform');
        $user_id = $request->get('user_id');
        if (isset($user_id)) {
            $user = User::find($user_id);
            $course_recommender = CourseRecommender::updateOrCreate(['user_id' => optional($user)->id, 'token_typeform' => $request->get('token_typeform')], ['token_typeform' => $token_typeform, 'u_key' => Str::uuid()]);
        } else {
            $course_recommender = CourseRecommender::updateOrCreate(['token_typeform' => $request->get('token_typeform')], ['token_typeform' => $token_typeform, 'u_key' => Str::uuid()]);
        }
        return response()->json($course_recommender);
    }

    public function webhooks(Request $request)
    {
        $answers = collect($request->input('form_response.answers'))
            ->keyBy('field.ref')
            ->transform(function ($answer) {
                return $answer[$answer['type']];
            });

        $course_recommender = CourseRecommender::firstOrCreate(['token_typeform' => $request->input('form_response.token')], ['u_key' => Str::uuid()]);
        $filters = $this->fetchCourseData($answers);
        $course_recommender->recommender_type = $filters;
        $course_recommender->save();
        return $course_recommender;
    }

    private function fetchCourseData($data): array
    {
        $filters = [];
        $filters['age'] = $data->get('2628e0f5-c7ef-408d-aed2-ad5aea307e97');
        $filters['skills'] = $data->get('5d348fdc-01e4-4d46-b8b3-864981001de5')['label'];
        $dailies = $data->get('d4e16e16-e210-4a36-a202-bf5d9e36e0a5', [])['labels'];
        $filter_daily = [];
        foreach ($dailies as $key => $daily) {
            if ($daily !== "Cualquier Horario") {
                $filter_daily[$key]['dailies'] = (string)array_keys(self::DAYS, trim(explode('-', $daily)[0]), true)[0];
                $filter_daily[$key]['starts_after_hour'] = trim(explode('-', $daily)[1]);
            } else {
                $filter_daily[$key]['dailies'] = null;
                $filter_daily[$key]['starts_after_hour'] = null;
            }
        }
        $filters['daily'] = array_unique(Arr::pluck($filter_daily, 'dailies'));
        $filters['starts_after_hour'] = array_unique(Arr::pluck($filter_daily, 'starts_after_hour'));
        if ($filter_daily[0]['dailies'] === null) {
            $filters['daily'] = null;
            $filters['starts_after_hour'] = null;
        }
        return $filters;
    }
}
