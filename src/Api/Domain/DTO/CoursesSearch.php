<?php

namespace Mi-empresa\Api\Domain\DTO;

class CoursesSearch
{
    private function __construct(
        private int $type_course,
        private ?string $areas,
        private ?string $categories,
        private ?string $specializations,
        private ?array $tag,
        private ?string $search,
        private ?array $age,
        private ?int $page,
        private ?int $limit
    ) {
    }

    public function areas(): ?string
    {
        return $this->areas;
    }

    public function categories(): ?string
    {
        return $this->categories;
    }

    public function specializations(): ?string
    {
        return $this->specializations;
    }

    public function typeCourse(): int
    {
        return $this->type_course;
    }

    public function age(): ?array
    {
        return $this->age;
    }

    public function tag(): ?array
    {
        return $this->tag;
    }

    public function search(): ?string
    {
        return $this->search;
    }

    public function toArray(): array
    {
        return [
            'areas' => $this->areas(),
            'categories' => $this->categories(),
            'specializations' => $this->specializations(),
            'type_course' => $this->typeCourse(),
            'tag' => $this->tag(),
            'page' => $this->page(),
            'age' => $this->age(),
            'search' => $this->search(),
            'limit' => $this->limit()
        ];
    }

    public static function createFromRequest(
        int $type_course,
        ?string $areas,
        ?string $categories,
        ?string $specializations,
        ?array $tag,
        ?array $age,
        ?string $search,
        ?int $page,
        ?int $limit
    ): self {
        return new self($type_course, $areas, $categories, $specializations, $tag, $search, $age, $page, $limit);
    }

    public function page(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page)
    {
        $this->page = $page;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(int $limit = 2)
    {
        $this->limit = $limit;
    }

    public function setTypeCourse(int $type_course): void
    {
        $this->type_course = $type_course;
    }

    public function isJustTag(): bool
    {
        if (empty($this->categories) && empty($this->areas) && empty($this->specializations) && isset($this->tag)) {
            return true;
        } else {
            return false;
        }
    }

    public function isJustTypeCourse(): bool
    {
        if (empty($this->categories) && empty($this->areas) && empty($this->specializations) && empty($this->tag) && isset($this->type_course)) {
            return true;
        } else {
            return false;
        }
    }
}
