<?php

namespace Lifecole\Api\Application\Tag\GetCoursesTag;

use App\Tag;
use Lifecole\Api\Domain\Repository\TagRepository;

class GetCoursesTagQueryHandler
{
    public function __construct(private TagRepository $tagRepository)
    {
    }

    public function __invoke(GetCoursesTagQuery $getCoursesTagQuery): array|null
    {
        $model = $this->tagRepository->findByParameters(
            $getCoursesTagQuery->selectColumns(),
            $getCoursesTagQuery->filtersColumns()
        );
        if ($model instanceof Tag) {
            return $model->toArray();
        }
        return $model;
    }
}
