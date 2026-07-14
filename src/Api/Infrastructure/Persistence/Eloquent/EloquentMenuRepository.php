<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\Course;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Lifecole\Api\Domain\DTO\CoursesSearch;
use Lifecole\Api\Domain\Repository\MenuRepository;

class EloquentMenuRepository implements MenuRepository
{
    private function getAreasWithRelations(bool $needs_courses = false, int $type_course = 1): array
    {
        $queryJoins = '';
        $querySelect = 'select a.id as a_id,a.title as a_title, a.slug as a_slug,
                cc.id as c_id, cc.title as cc_title, cc.slug as cc_slug,
                cs.id as cs_id, cs.title as cs_title, cs.slug as cs_slug ';
        $queryFilters = ' where a.is_active=1 and cc.is_active=1 and cs.is_active=1';
        $queryOrder = ' order by a.id, cc.id';
        if ($needs_courses) {
            $querySelect .= ', c.title, c.slug as c_slug ';
            $queryJoins = ' inner join courses c on c.course_specialization_id=cs.id 
                            inner join promotions p on c.id=p.course_id';
            $queryFilters .= ' and c.is_visible=1 and p.end_at>NOW() and c.type_course=' . $type_course . ' ';
        }
        $query = $querySelect .
            ' from course_area a
                inner join course_category cc on a.id = cc.course_area_id
                inner join course_specialization cs on cc.id = cs.course_category_id' .
            $queryJoins .
            $queryFilters .
            $queryOrder;
        return DB::select($query);
    }

    public function getTreeElementsIntensives(): array
    {
        $ids_areas_restrict_pluck_id = $this->getIdsActivesAreas(Course::TYPE_INTENSIVE);

        $ids_categories_restrict_pluck_id = $this->getIdsActivesCategories(Course::TYPE_INTENSIVE);

        $ids_specialization_restrict_pluck_id = $this->getIdsActivesSpecialization(Course::TYPE_INTENSIVE);

        $ids_tags_categories = $this->getTagsFromCategories();
        $rows = $this->getAreasWithRelations(true, Course::TYPE_INTENSIVE);

        $filters = [
            'ids_areas_restrict_pluck_id' => $ids_areas_restrict_pluck_id,
            'ids_categories_restrict_pluck_id' => $ids_categories_restrict_pluck_id,
            'ids_specialization_restrict_pluck_id' => $ids_specialization_restrict_pluck_id,
            'ids_tags_categories' => $ids_tags_categories,
            'needs_keys_url' => 'slug',
            'courses' => true
        ];
        return $this->groupByAreasRelations($rows, $filters);
    }

    public function getTreeElementsTrajectories(): array
    {

        $ids_areas_restrict_pluck_id = $this->getIdsActivesAreas(Course::TYPE_TRAJECTORY);

        $ids_categories_restrict_pluck_id = $this->getIdsActivesCategories(Course::TYPE_TRAJECTORY);

        $ids_specialization_restrict_pluck_id = $this->getIdsActivesSpecialization(Course::TYPE_TRAJECTORY);

        $ids_tags_categories = $this->getTagsFromCategories();
        $rows = $this->getAreasWithRelations(true, Course::TYPE_TRAJECTORY);

        $filters = [
            'ids_areas_restrict_pluck_id' => $ids_areas_restrict_pluck_id,
            'ids_categories_restrict_pluck_id' => $ids_categories_restrict_pluck_id,
            'ids_specialization_restrict_pluck_id' => $ids_specialization_restrict_pluck_id,
            'ids_tags_categories' => $ids_tags_categories,
            'needs_keys_url' => 'slug',
            'courses' => true
        ];
        return $this->groupByAreasRelations($rows, $filters);
    }

    public function getElementsFromMenu(): array
    {
        $ids_areas_restrict_pluck_id = $this->getIdsActivesAreas(Course::TYPE_TRAJECTORY);

        $ids_categories_restrict_pluck_id = $this->getIdsActivesCategories(Course::TYPE_TRAJECTORY);

        $ids_specialization_restrict_pluck_id = $this->getIdsActivesSpecialization(Course::TYPE_TRAJECTORY);

        $ids_tags_categories = $this->getTagsFromCategories();

        $rows = $this->getAreasWithRelations(false, Course::TYPE_TRAJECTORY);

        $filters = [
            'ids_areas_restrict_pluck_id' => $ids_areas_restrict_pluck_id,
            'ids_categories_restrict_pluck_id' => $ids_categories_restrict_pluck_id,
            'ids_specialization_restrict_pluck_id' => $ids_specialization_restrict_pluck_id,
            'ids_tags_categories' => $ids_tags_categories,
            'needs_keys_url' => 'url',
            'courses' => false
        ];
        return $this->groupByAreasRelations($rows, $filters);
    }

    private function groupByAreasRelations($rows, $filters): array
    {
        $ids_areas_restrict_pluck_id = $filters[ 'ids_areas_restrict_pluck_id' ];
        $ids_categories_restrict_pluck_id = $filters[ 'ids_categories_restrict_pluck_id' ];
        $ids_specialization_restrict_pluck_id = $filters[ 'ids_specialization_restrict_pluck_id' ];
        $ids_tags_categories = $filters[ 'ids_tags_categories' ];
        $needs_courses = $filters[ 'courses' ] ?? false;
        $needs_url = $filters[ 'needs_keys_url' ] ?? 'url';
        $prefix_needs_url = $filters[ 'needs_keys_url' ] ? '/cursos?' : '';
        $array = [];

        foreach ($rows as $row) {
            $row = (array) $row;
            if (isset($row[ 'a_slug' ])) {
                if (!$needs_courses) {
                    $array [ $row[ 'a_slug' ] ][ $needs_url ] = $prefix_needs_url . 'area=' . $row[ 'a_slug' ];
                    if (isset($row[ 'a_id' ]) && in_array($row[ 'a_id' ], $ids_areas_restrict_pluck_id)) {
                        $array [ $row[ 'a_slug' ] ][ $needs_url ] .= '&type_course=trajectories';
                    } else {
                        $array [ $row[ 'a_slug' ] ][ $needs_url ] .= '&type_course=intensive';
                    }
                } else {
                    $array [ $row[ 'a_slug' ] ][ $needs_url ] = $row[ 'a_slug' ];
                }

                $array [ $row[ 'a_slug' ] ][ 'title' ] = $row[ 'a_title' ];

                if (isset($row[ 'cc_slug' ])) {
                    if (!$needs_courses) {
                        $array [ $row[ 'a_slug' ] ][ 'categories' ][ $row[ 'cc_slug' ] ][ $needs_url ] = $prefix_needs_url . 'categories=' . $row[ 'cc_slug' ];
                        if (isset($row[ 'cs_id' ]) && in_array($row[ 'cs_id' ], $ids_categories_restrict_pluck_id)) {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ][ $row[ 'cc_slug' ] ][ $needs_url ] .= '&type_course=trajectories';
                        } else {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ][ $row[ 'cc_slug' ] ][ $needs_url ] .= '&type_course=intensives';
                        }
                    } else {
                        $array [ $row[ 'a_slug' ] ][ 'categories' ][ $row[ 'cc_slug' ] ][ $needs_url ] = $row[ 'cc_slug' ];
                    }

                    if (!$needs_courses) {
                        if (isset($ids_tags_categories[ $row[ 'cc_slug' ] ])) {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ]  [ $row[ 'cc_slug' ] ]  [ 'tags' ] = $ids_tags_categories[ $row[ 'cc_slug' ] ];
                        } else {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ]  [ $row[ 'cc_slug' ] ]  [ 'tags' ] = [];
                        }
                    }
                    $array [ $row[ 'a_slug' ] ][ 'categories' ][ $row[ 'cc_slug' ] ][ 'title' ] = $row[ 'cc_title' ];

                    if (isset($row[ 'cs_slug' ])) {
                        if (!$needs_courses) {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ] [ $row[ 'cc_slug' ] ] [ 'specialization' ] [ $row[ 'cs_slug' ] ][ $needs_url ]
                                = '/cursos' . '?specializations=' . $row[ 'cs_slug' ];
                            if (isset($row[ 'cs_id' ]) && in_array($row[ 'cs_id' ], $ids_specialization_restrict_pluck_id)) {
                                $array [ $row[ 'a_slug' ] ][ 'categories' ] [ $row[ 'cc_slug' ] ] [ 'specialization' ] [ $row[ 'cs_slug' ] ][ $needs_url ] .=
                                    '&type_course=trajectories';
                            } else {
                                $array [ $row[ 'a_slug' ] ][ 'categories' ] [ $row[ 'cc_slug' ] ] [ 'specialization' ] [ $row[ 'cs_slug' ] ][ $needs_url ] .=
                                    '&type_course=intensives';
                            }
                        } else {
                            $array [ $row[ 'a_slug' ] ][ 'categories' ] [ $row[ 'cc_slug' ] ] [ 'specialization' ] [ $row[ 'cs_slug' ] ][ $needs_url ] =
                                $row[ 'cs_slug' ];
                        }

                        $array [ $row[ 'a_slug' ] ][ 'categories' ] [ $row[ 'cc_slug' ] ] [ 'specialization' ] [ $row[ 'cs_slug' ] ][ 'title' ] =
                            $row[ 'cs_title' ];
                    }
                }
            }
        }
        return $array;
    }

    private function getIdsActivesAreas(int $type_course): array
    {
        $filter = 'and c.type_course =' . $type_course;
        $query = 'select ca.id from course_area ca inner join course_category cc on ca.id = cc.course_area_id
                inner join course_specialization cs on cc.id = cs.course_category_id
                inner join courses c on c.course_specialization_id = cs.id inner join promotions p on c.id = p.course_id
                where c.is_visible=1 and p.end_at>NOW() ' .
            $filter .
            ' group by ca.id';
        $rows = DB::select($query);
        return array_unique(array_column($rows, 'id'));
    }

    private function getIdsActivesCategories(int $type_course): array
    {
        $filter = 'and c.type_course =' . $type_course;
        $query = 'select cc.id from course_category cc inner join course_specialization cs on cc.id = cs.course_category_id
                inner join courses c on c.course_specialization_id = cs.id
                inner join promotions p on c.id = p.course_id
                where c.is_visible=1 and p.end_at>NOW() ' .
            $filter .
            ' group by cc.id';
        $rows = DB::select($query);
        return array_unique(array_column($rows, 'id'));
    }

    private function getIdsActivesSpecialization(int $type_course): array
    {
        $filter = 'and c.type_course =' . $type_course;
        $query = 'select cs.id from course_specialization cs inner join courses c on c.course_specialization_id = cs.id
                inner join promotions p on c.id = p.course_id
                where c.is_visible=1 and p.end_at>NOW() ' .
            $filter .
            ' group by cs.id';
        $rows = DB::select($query);
        return array_unique(array_column($rows, 'id'));
    }

    private function getTagsFromCategories(): array
    {
        $query = 'select cc.id, cc.slug as cc_slug, t.slug as t_slug, t.title from course_category cc
                inner join  course_category_rel_tag ct on cc.id=ct.course_category_id
                inner join tag t on t.id=ct.tag_id
                where t.is_active=1';
        $tags_categories = DB::select($query);
        $ids_tags_categories = [];
        foreach ($tags_categories as $id_tag_category) {
            $id_tag_category = (array) $id_tag_category;
            $tag = $id_tag_category[ 'cc_slug' ];
            unset($id_tag_category[ 'cc_slug' ]);
            $ids_tags_categories[ $tag ] [] = [ 'url' => '/cursos?tag=' . $id_tag_category[ 't_slug' ], 'title' => $id_tag_category[ 'title' ] ];
        }
        return $ids_tags_categories;
    }

    public function getTitlesFromSlugsMenu(CoursesSearch $coursesSearch, array $responseFilter): array
    {
        $filters = $coursesSearch->toArray();
        $selected = [];
        if (isset($filters[ 'areas' ]) && isset($responseFilter[ $filters[ 'areas' ] ])) {
            $selected[ 'area' ][ 'title' ] = $responseFilter[ $filters[ 'areas' ] ][ 'title' ] ?? null;
            $selected[ 'area' ][ 'slug' ] = $responseFilter[ $filters[ 'areas' ] ][ 'slug' ] ?? null;
            if (isset($filters[ 'categories' ]) && isset($responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ])) {
                $selected[ 'categories' ][ 'title' ] = $responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ][ 'title' ];
                $selected[ 'categories' ][ 'slug' ] = $responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ][ 'slug' ];
                if (isset($filters[ 'specializations' ]) && isset($responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ][ 'specialization' ] [ $filters[ 'specializations' ] ])) {
                    $selected[ 'specializations' ][ 'title' ] =
                        $responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ][ 'specialization' ]
                        [ $filters[ 'specializations' ] ][ 'title' ];
                    $selected[ 'specializations' ][ 'slug' ] =
                        $responseFilter[ $filters[ 'areas' ] ][ 'categories' ][ $filters[ 'categories' ] ][ 'specialization' ]
                        [ $filters[ 'specializations' ] ][ 'slug' ];
                }
            }
        }
        if (isset($filters['type_course'])) {
            $selected[ 'type_course' ] = $filters['type_course'];
            $selected[ 'view_type' ] = 'type_courses';
        }
        return $selected;
    }

}
