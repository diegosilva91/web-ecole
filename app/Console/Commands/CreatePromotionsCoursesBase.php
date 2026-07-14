<?php

namespace App\Console\Commands;

use App\Course;
use App\CourseSpecialization;
use App\Promotion;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreatePromotionsCoursesBase extends Command
{
    /**
     * Promotions for base courses.
     *
     * @var string
     */
    protected $signature = 'promotions:create_for_courses_base
                            {specialization_id : Course specialization id}
                            {--course_id= : Course_id. Optional}
                            {--type_course= : Type of the course (see class Course). Optional}
                            {--month_start= : Months start}
                            {--months= : Months to loop}
                            {--months_restrict= : Months restrict to avoid }
                            {--delete= : Delete. Optional}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create promotions in base courses.It will create promotions
                eg. php artisan promotions:create_for_courses_base 1 --months=6 --months_restrict=2';

    private $months_loop;

    private $months_restrict;

    private $delete;

    /**
     * @var array|bool|string|null
     */
    private $month_start;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $course_specialization_id = $this->argument('specialization_id');
        $course_id = empty($this->option('course_id')) ? null : $this->option('course_id');

        $this->months_loop = $this->option('months');
        $this->month_start = $this->option('month_start');
        $this->months_restrict = (int)$this->option('months_restrict');
        $this->delete = empty($this->option('delete')) ? null : $this->option('delete');
        $this->type_course = empty($this->option('type_course')) ? null : $this->option('type_course');
        $course_specialization = CourseSpecialization::find($course_specialization_id);
        $courses = $this->getcourses($course_specialization->id, $this->type_course, $course_id);
        if (isset($courses)) {
            $promotions = Promotion::whereIn('course_id', $courses->pluck('id'))->orderBy('start_at')->get();
            if (empty($promotions) || count($promotions) === 0) {
                echo "empty promotions";
                return 1;
            }
            echo "Number  |  Course Id  |  Duration";
            $this->loopCourses($courses);
        } else {
            echo "empty courses";
        }
        return 0;
    }

    private function loopCourses($courses)
    {
        $courses->each(function ($course, $index) {
            if (isset($course)) {
                $duration = $course->duration ?? 4;
                echo "\n Course # $index | " . $course->id . " | " . Str::substr($course->title, 0, 30) . " | " . $course->duration;
                /********* Check Promotions if exist ******/
                if (count($course->promotions) > 0) {
                    $first_start_at = Carbon::parse($course->promotions->first()->start_at);
                    echo " | first month ( " . $first_start_at->format('F') . " | " . $first_start_at->month . " )\n";
                    /****************       Check if start_month exist *****************************************************/
                    /****************for getting base promotions with mont_start after actual month ************************/
                    if (isset($this->month_start)) {
                        $base_promotions = $course->promotions->whereBetween('start_at', [now()->addMonths($this->month_start)->startOfMonth()->startOfWeek(), now()->addMonths($this->month_start)->endOfMonth()]);
                    } else {
                        $base_promotions = $course->promotions->whereBetween('start_at', [now()->startOfMonth()->startOfWeek(), now()->endOfMonth()]);
                    }
                    $this->table(['Id', 'Course_id', 'Title', 'Start_at', 'End_at', 'Daily'], $base_promotions->toArray());
                    echo "total base promo = " . count($base_promotions) . " | ";
                    if (count($base_promotions) > 0) {
                        /****************       Check if start_month exist ***********************************************/
                        /**************** For getting next promotions after mont_start         ***************************/
                        /**************** if not exist take next_promotions from actual month end ************************/
                        if (isset($this->month_start)) {
                            $next_promotions = $course->promotions->whereBetween('start_at', [now()->addMonths($this->month_start)->endOfMonth(), now()->addYear()->endOfYear()])->pluck('id');
                        } else {
                            $next_promotions = $course->promotions->whereBetween('start_at', [now()->endOfMonth(), now()->addYear()->endOfYear()])->pluck('id');
                        }
                        //delete promotions next if delete is isset
                        if (isset($this->delete)) {
                            if ($this->delete == 'true') {
                                $promotions = Promotion::whereDoesntHave('promotionPurchasesAll')->whereIn('id', $next_promotions)->delete();
                                echo "| promotions delete " . $promotions . " | ";
                            }
                        }
                    }
                    //Create new promotions
                    $base_promotions->sortBy('start_at')->each(function ($promotion) use ($first_start_at, $course, $duration) {
                        $data_promotions = [];
                        $headers = ['i', 'Before start_at_week', 'Next Month', 'Day start_at', 'String', 'start_at result', 'end_at', 'dif'];
                        $start_at_week = Carbon::parse($promotion->start_at);
                        for ($i = 1; $i <= $this->months_loop; $i++) {
                            //Testing$start_at_week first its start_at of exist promotion then start_at of created promotion last loop ($i-1)
                            //$next_month=Carbon::parse ( $promotion->start_at )->addMonths($i);
                            $next_day = $start_at_week->format('l');
                            $month_number = $start_at_week->month;
                            echo "\n $i |Before   $start_at_week";
                            $next_month = $start_at_week->addMonth();
                            /**** know year**/
                            $year =  $next_month->month - now()->addMonths($this->month_start)->month > 0 ? now()->year : now()->addYear()->year;
                            /*** **/
                            echo " | Next Month " . $next_month . " | " . $next_day;
                            $string_start_at = 'First ' . $next_day . ' of ' . $next_month->format('F') . ' ' . $year;
                            echo " | $string_start_at | " . Carbon::parse($string_start_at) . " | ";
                            $end_at = Carbon::parse($string_start_at)->addWeeks($duration - 1);
                            /**** Restrictions
                             * Add month previously  and skip this loop
                             * in next loop take the last addMonth and plus another month.
                             **
                             */
                            if ($i === $this->months_restrict) {
                                $start_at_week = Carbon::parse($string_start_at)->setTime($start_at_week->hour, $start_at_week->minute);
                                echo " | skip\n";
                                continue;
                            }
                            //Create or update promotion
                            $promotion_new = Promotion::updateOrCreate(
                                [
                                'course_id' => $course->id,
                                'daily' => $promotion->daily,//$days_daily,
                                'start_at' => Carbon::parse($string_start_at)->setTime($start_at_week->hour, $start_at_week->minute)
                                ],
                                ['end_at' => $end_at->setTime($start_at_week->hour, $start_at_week->minute)]
                            );

                            $data = [
                                'i' => $i,
                                'start_at_week' => Carbon::parse($promotion->start_at),
                                'next_month' => "$next_month ",
                                'next_day' => " $next_day",
                                'string' => $string_start_at,
                                'start_at result' => $promotion_new->start_at,
                                'end_at' => $end_at,
                                'dif' => Carbon::parse($promotion_new->start_at)->diffInDays($end_at)
                            ];
                            array_push($data_promotions, $data);
                            $start_at_week = Carbon::parse($promotion_new->start_at);

                            echo " Result " . $promotion_new->start_at . " \n ";
                        }
                        $this->table($headers, $data_promotions);
                    });
                } else {
                    echo " | Empty Course promotions 0 \n";
                }
            }
        });
    }

    private function getCourses($specialization_id, $type_course, $course_id)
    {
        return Course::where('course_specialization_id', $specialization_id)
            ->when(isset($course_id), function ($query) use ($course_id) {
                return $query->where('id', $course_id);
            })
            ->when(isset($type_course), function ($query) use ($type_course) {
                return $query->where('type_course', $type_course);
            })
            ->get();
    }
}
