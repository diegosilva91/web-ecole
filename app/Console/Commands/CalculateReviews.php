<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Mi-empresa\Api\Application\Reviews\CalculateReviewsCourse\CalculateReviewsCourseCommand;
use Mi-empresa\Api\Application\Reviews\CalculateReviewsTeacher\CalculateReviewsTeachersCommand;
use Mi-empresa\Api\Application\Reviews\ComputeTotalReviews\ComputeTotalReviewsCommand;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;

class CalculateReviews extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'reviews:calculate_ratings
                            {--course_id= : Course Id for calculate ratings}
                            {--user_id= : User Id teacher\'s table for calculate ratings}';

    /**
     * The console command description.
     */
    protected $description = 'Compute or Calculate reviews total and average from course id and user id';
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    public function handle(): int
    {
        if (Arr::has($this->options(), 'course_id') && isset($this->options()['course_id'])) {
            $courseId = CourseId::create((int)$this->options()['course_id']);
            $this->commandBus->dispatch(new CalculateReviewsCourseCommand($courseId));
        }
        if (Arr::has($this->options(), 'user_id') && isset($this->options()['user_id'])) {
            $userId = UserId::create((int)$this->options()['user_id']);
            $this->commandBus->dispatch(new CalculateReviewsTeachersCommand($userId));
        }
        if (empty($this->options()['course_id']) && empty($this->options()['user_id'])) {
            $this->commandBus->dispatch(new ComputeTotalReviewsCommand());
        }
        return 0;
    }
}
