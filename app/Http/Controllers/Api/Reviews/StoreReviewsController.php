<?php

namespace App\Http\Controllers\Api\Reviews;

use App\Mail\Internal\NewReviewCreated;
use App\User;
use Illuminate\Http\Request;
use Lifecole\Api\Application\Reviews\AddReview\AddReviewCommand;
use Lifecole\Api\Domain\Helper\DecryptTokenReviewsForm;
use Lifecole\Event\Domain\Bus\Command\CommandBus;
use Lifecole\Shared\Domain\Repository\Mailer;
use Lifecole\Shared\Domain\ValueObject\CourseId;
use Lifecole\Shared\Domain\ValueObject\UserId;

class StoreReviewsController
{
    public function __construct(private CommandBus $commandBus, private DecryptTokenReviewsForm $decryptTokenReviewsForm)
    {
    }

    public function storeReview(Request $request, string $token, Mailer $mailer)
    {
        $dataToken = $this->decryptTokenReviewsForm->dataFromToken($token);
        $user_id = UserId::create($dataToken['user_id']);
        $course_id = CourseId::create($dataToken['course_id']);
        $teacher_id = UserId::create($request->get('teacher_id', 0));
        $rating1 = $request->get('rating1', 0);
        $rating2 = $request->get('rating2', 0);
        $rating3 = $request->get('rating3', 0);
        $rating4 = $request->get('rating4', 0);
        $opinion = $request->get('opinion', 0);
        $this->commandBus->dispatch(new AddReviewCommand(
            $user_id,
            $course_id,
            $teacher_id,
            $rating1,
            $rating2,
            $rating3,
            $rating4,
            $opinion
        ));

        $user = User::find($dataToken['user_id']);
        $mailer->send(new NewReviewCreated($user));

        return response()->json([], 201);
    }
}
