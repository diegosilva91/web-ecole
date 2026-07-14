<?php

namespace App\Http\Controllers\Web;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class LandingController extends Controller
{
    public function tech()
    {
        $parameters = [
            'area' => [ 'slug' => 'informatica-programacion-y-sistemas' ]
        ];
        return view('pages.verticalTech', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techSchool()
    {
        $parameters = [
            'area' => [ 'slug' => 'educacion-metodologia-e-idiomas' ],
            'categories' => [ 'slug' => 'idiomas' ]
        ];
        return view('pages.techSchool', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techCode()
    {
        $parameters = [
            'area' => [ 'slug' => 'informatica-programacion-y-sistemas' ],
            'categories' => [ 'slug' => 'programacion' ],
        ];
        return view('pages.techCode', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techRs()
    {
        $parameters = [
            'area' => [ 'slug' => 'desarrollo-de-marca-y-estrategia-digital' ],
        ];
        return view('pages.techRs', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techWeb()
    {
        $parameters = [
            'area' => [ 'slug' => 'informatica-programacion-y-sistemas' ],
            'categories' => [ 'slug' => 'desarrollo-web-y-cloud' ],
        ];
        return view('pages.techWeb', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techRobot()
    {
        $parameters = [
            'area' => [ 'slug' => 'robotica-e-ingenieria-industrial' ],
        ];
        return view('pages.techRobot', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techGame()
    {
        $parameters = [
            'area' => [ 'slug' => 'informatica-programacion-y-sistemas' ],
            'categories' => [ 'slug' => 'creacion-de-videojuegos' ],
        ];
        return view('pages.techGame', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techOffice()
    {
        $parameters = [
            'area' => [ 'slug' => 'informatica-programacion-y-sistemas' ],
            'categories' => [ 'slug' => 'informatica-general' ],
        ];

        return view('pages.techOffice', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techDesign()
    {
        $parameters = [
            'area' => [ 'slug' => 'arte-digital' ],
        ];

        return view('pages.techDesign', [ 'optionsRequestSelected' => $parameters ]);
    }

    public function techWinter(): Factory|View|Application|RedirectResponse
    {
        return redirect()->action('Web\Courses\CoursesController@courses')->setStatusCode(301);
        /*
        $infoCampus = [
            'campus' => 'inverno',
            'img' => 'winter',
            'bg' => 'bg-tech-red',
            'title' => 'Campamento de Invierno',
            'description' => 'Estas Navidades regala educación y un futuro a tus hijos con nuestros campus de programación y redes sociales. Inscribe a tus hijos en nuestros campus de Navidad del día 27/12 al 30/12 y descubre todos nuestros horarios.',
            'subtype_course' => Course::SUBTYPE_CAMPUS_WINTER
        ];
        return view('pages.techCampus', ['infoCampus' => $infoCampus]);
        */
    }

    public function techHolyWeek(): Factory|View|Application|RedirectResponse
    {
        //return redirect()->action('Web\Courses\CoursesController@courses')->setStatusCode(301);

        $infoCampus = [
            'campus' => 'holy_week',
            'img' => 'campus_holy_week',
            'bg' => 'bg-tech-purple',
            'title' => 'Campus de Semana Santa',
            'description' => 'Esta semana santa <span>regala educaci&oacute;n</span> y un futuro a tus hijos con nuestros campus de nuevas tecnolog&iacute;as. Inscribe a tus hijos en nuestros campus del d&iacute;a <span>11/04</span> al <span>13/04</span> y descubre todos nuestros horarios.',
            'subtype_course' => Course::SUBTYPE_CAMPUS_HOLY_WEEK
        ];
        return view('pages.techCampus', [ 'infoCampus' => $infoCampus ]);
    }

    public function techSummer(): Factory|View|Application|RedirectResponse
    {
        //return redirect()->action('Web\Courses\CoursesController@courses')->setStatusCode(301);

        $infoCampus = [
            'campus' => 'summer',
            'img' => 'campus_summer',
            'bg' => 'bg-tech-blue',
            'title' => 'Campus de verano',
            'description' => 'Este verano <span>invierte en educaci&oacute;n</span> y en un futuro para tus hijos con nuestros campus de <span>nuevas tecnolog&iacute;as</span>. Inscribe a tus hijos en nuestros campus de verano semanales que comienzan el <span>27 de Junio hasta el 2 de Septiembre</span> &iexcl;Descubre una amplia oferta de cursos con diferentes horarios!',
            'subtype_course' => Course::SUBTYPE_CAMPUS_SUMMER
        ];
        return view('pages.techCampus', [ 'infoCampus' => $infoCampus ]);
    }

    public function teachers()
    {
        return view('pages.teacher');
    }

    public function promo()
    {
        return view('pages.promoLanding');
    }
}
