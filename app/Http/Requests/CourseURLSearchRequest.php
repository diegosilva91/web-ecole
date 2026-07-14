<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CourseURLSearchRequest extends FormRequest
{
    public function rules()
    {
        return [
        ];
    }

    protected function prepareForValidation()
    {
        $routes = explode('/', $this->route('any'));
        foreach ($routes as $route) {
            if (Str::startsWith($route, 'categoria')) {
                $category = Str::replace('categoria-', '', $route);
                $this->merge([ 'category' => $category ]);
            }
            if (Str::startsWith($route, 'especializacion')) {
                $specialization = Str::replace('especializacion-', '', $route);
                $this->merge([ 'specialization' => $specialization ]);
            }
            if (Str::startsWith($route, 'area')) {
                $area = Str::replace('area-', '', $route);
                $this->merge([ 'area' => $area ]);
            }
            if (Str::startsWith($route, 'age')) {
                $age = Str::replace('age-', '', $route);
                $this->merge([ 'age' => $age ]);
            }
            if (Str::startsWith($route, 'tag')) {
                $tag = Str::replace('tag-', '', $route);
                $tags = explode('/', $tag);
                $this->merge([ 'tag' => $tags ]);
            }
        }
    }
}
