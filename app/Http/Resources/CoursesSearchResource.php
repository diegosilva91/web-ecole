<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursesSearchResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    public function toArray($request): array
    {
        $resourceArray = $this->resource->toArray();
        $data = [
            'id' => $resourceArray[ 'id' ],
            'type_course' => $resourceArray[ 'type_course' ],
            'subtype_course' => $resourceArray[ 'subtype_course' ],
            'title' => $resourceArray[ 'title' ],
            'cover_image' => $resourceArray[ 'cover_image' ],
            'cover_image_mobile' => $resourceArray[ 'cover_image_mobile' ],
            'student_ages_min' => $resourceArray[ 'student_ages_min' ],
            'student_ages_max' => $resourceArray[ 'student_ages_max' ],
            'students_max' => $resourceArray ['students_max'],
            'students_min' => $resourceArray['students_min'],
            'newLink' => $resourceArray[ 'newLink' ],
            'duration' => $resourceArray[ 'duration' ],
            'price_total' => $resourceArray[ 'price_total' ],
            'price_per_hour' => $resourceArray[ 'price_per_hour' ],
            'discount' => $resourceArray[ 'discount' ],
            'total_reviews' => $resourceArray[ 'total_reviews' ],
            'avg_reviews' => $resourceArray[ 'avg_reviews' ],
            'first_promotion' => new PromotionSearchResource($resourceArray[ 'first_promotion' ]),
        ];
        if (isset($resourceArray [ 'last_promotion' ])) {
            $data['session'] = $resourceArray[ 'session' ];
            $data['sessionTime'] = $resourceArray[ 'sessionTime' ];
            $data[ 'last_promotion' ] =  new PromotionSearchResource($resourceArray [ 'last_promotion' ]);
//            $data[ 'available_first_promotion'] =   new PromotionSearchResource($resourceArray [ 'available_first_promotion']);
        }
        return $data;
    }
}
