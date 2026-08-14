<?php

namespace App\Http\Controllers\Web;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Mi-empresa\Api\Application\Reviews\GetReviewFormByToken\GetReviewFormByTokenQuery;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Event\Domain\Bus\Query\QueryBus;

class ReviewsController
{
    public function __construct(private QueryBus $queryBus, private CdnAdapter $cdnAdapter)
    {
    }

    public function showReviewsForm(string $token): Factory|View|Application
    {
        $baseUrl = $this->cdnAdapter->base();
        try {
            $reviewForm = $this->queryBus->ask(
                new GetReviewFormByTokenQuery($token)
            );
            $dataReview = [
                'token' => $token,
                'course_users' => $reviewForm->coursesUsers(),
                'title' => $reviewForm->title(),
                'url' => $baseUrl
            ];
        } catch (\Exception $e) {
            $dataReview = ['exist' => true];
            if ($e->getMessage() !== "Course review exist") {
                return view('pages.reviews');
            }
        }

        return view('pages.reviews', $dataReview);
    }
}
