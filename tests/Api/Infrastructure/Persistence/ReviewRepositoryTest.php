<?php

namespace Tests\Api\Infrastructure\Persistence;

use App\Course;
use App\CourseReviews;
use App\User;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseReviewsRepository;
use Tests\TestCase;

class ReviewRepositoryTest extends TestCase
{
    private $reviews;
    private $newCourseReview;

    protected function setUp(): void
    {
        parent::setUp();

        $course = Course::firstOrCreate(['title' => 'Test Course']);
        $user = User::firstOrCreate(['email' => 'test221321@gmail.com', 'password' => 'ILOVELARAVEL', 'name' => 'test']);
        $teacher = $user->teacherCourse()->create(['title' => 'Teacher Laravel']);
        $this->newCourseReview = CourseReviews::firstOrCreate([
            'course_id' => $course->id, 'user_id' => $user->id, 'teacher_id' => $teacher->id,
            'rating1' => '0.5',
            'rating2' => '0.8',
            'rating3' => '0.0',
            'rating4' => '0.0',
            'opinion' => null,
        ]);

        $this->reviews = CourseReviews::all();
    }

    public function testRetrieveAll()
    {
        $reviewRepository = new EloquentCourseReviewsRepository;

        $data = $reviewRepository->retrieveAll();

        $this->assertEquals($data, $this->reviews);
    }

    public function testGetAvgColumn()
    {
        $reviewRepository = new EloquentCourseReviewsRepository;

        $data = $reviewRepository->getByColumn('id', $this->newCourseReview->id)->getAvgColumn('rating1');

        $this->assertEquals($data, 0.5);
    }
}
