<?php

namespace Tests\Api\Application\Reviews\AddReview;

use App\Course;
use App\User;
use Mi-empresa\Api\Application\Reviews\AddReview\AddReviewCommand;
use Mi-empresa\Api\Application\Reviews\AddReview\AddReviewCommandHandler;
use Mi-empresa\Event\Domain\Bus\Command\CommandBus;
use Mi-empresa\Shared\Domain\ValueObject\CourseId;
use Mi-empresa\Shared\Domain\ValueObject\UserId;
use Tests\TestCase;

class AddReviewTest extends TestCase
{
    private $handler;
    private $bus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bus = $this->getMockBuilder(CommandBus::class)->getMock();
    }

    protected function _before()
    {
        $this->handler = app()->make(AddReviewCommandHandler::class);
    }

    public function testAddReview()
    {
//        $this->bus->method('getHandlerClass')->willReturn(CommandBusTestHandler::class);
//         $this->assertInstanceOf('', $this->bus);
//        dd($this->bus->method('resolveHandler'));
        $user = User::firstOrCreate(['email' => 'test221321@gmail.com', 'password' => 'ILOVELARAVEL', 'name' => 'test']);
        $course = Course::firstOrCreate(['title' => 'Test Course']);
        $teacher = $user->teacherCourse()->create(['title' => 'Teacher Laravel']);
        $command = new AddReviewCommand(
            UserId::create($user->id),
            CourseId::create($course->id),
            UserId::create($teacher->id),
            '0.5',
            '0.8',
            '0.0',
            '0.0',
            null
        );
        $responseCommand = null;//;$this->handler->__invoke();
        $this->assertNull($responseCommand);
        $user->delete();
        $course->delete();
        $teacher->delete();
    }
}
