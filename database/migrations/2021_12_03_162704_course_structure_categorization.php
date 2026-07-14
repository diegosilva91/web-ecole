<?php

use App\CourseArea;
use App\CourseCategory;
use App\CourseSpecialization;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseStructureCategorization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_area', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('title',100);
            $table->string('slug',100);
            $table->tinyInteger('is_active')->default(1);
        });

        Schema::create('course_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('course_area_id')->unsigned();
            $table->string('title',100);
            $table->string('slug',100);
            $table->tinyInteger('is_active')->default(1);
            $table->foreign('course_area_id','course_area_id_foreign')
                ->references('id')->on('course_area')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::create('course_specialization', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('course_category_id')->unsigned();
            $table->string('title',100);
            $table->string('slug',100);
            $table->tinyInteger('is_active')->default(1);
            $table->foreign('course_category_id','course_category_id_foreign')
                ->references('id')->on('course_category')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->bigInteger('course_specialization_id')->unsigned()->nullable()->default(null)->after('user_id');
            $table->foreign('course_specialization_id','course_specialization_id_foreign')
                ->references('id')->on('course_specialization')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        $area = CourseArea::create(['title' => 'Escuela y Modelo HSTEAM']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Modelo HSTEAM']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'HSTEAM']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Educadores']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'SUPP Escolar']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Técnicas de estudio']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Lengua']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Matemáticas']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Ciencia']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Escuela a medida']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Clases']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Sesiones académicas especializadas']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Competencias transversales']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Comunicación']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Liderazgo y emprendimiento']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Habilidades socio-emocionales']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Escuela para educadores']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Capacitación profesional']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Idiomas']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Inglés ']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Francés']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Alemán']);

        $area = CourseArea::create(['title' => 'Informática, programación y sistemas']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Informática General']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Alfabetización digital']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Ofimática']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Navegación y seguridad']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Programación']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Programación educativa']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Programación profesional']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Creación de Videojuegos']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Programación y videojuegos']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Programación y Minecraft']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Programación y Roblox']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Videojuegos profesionales']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Desarrollo Web y Cloud']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Creación y diseño web']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Webs profesionales']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Aplicaciones en Web']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Entorno cliente-servidor']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Entorno cloud and Internet of things']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Desarrollo Apps']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Apps fáciles']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Apps profesionales']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Data Science']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Data Science y Machine Learning']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Networking y seguridad']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Redes, ciberseguridad y hacking']);

        $area = CourseArea::create(['title' => 'Robótica e ingeniería industrial']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Robótica educativa y profesional']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Robots y programación']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Robots e inteligencia artificial']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Robots and internet of things']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Diseño Técnico e Industrial']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Diseño técnico industrial']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Diseño arquitectónico']);

        $area = CourseArea::create(['title' => 'Arte digital']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Ilustración, pintura y diseño gráfico digital']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Dibujo, ilustración y diseño gráfico']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Ilustración y cómic']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Diseño y animación de personajes']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Modelado 3D y escultura digital']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Modelado 3D']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Realidad virtual']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Realismo, escenografía y reconstrucción']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Modelado de personajes']);

        $area = CourseArea::create(['title' => 'Producción audiovisual']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Modelado 3D y animación']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Modelado 3D y animación']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Modelado 3D, animación y simulaciones']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Modelado 3D, animación y personajes']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Producción multimedia']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Bases de producción multimedia']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Edición profesional video y audio']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Composición digital VFX']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Animación 2D con motion graphics']);

        $area = CourseArea::create(['title' => 'Desarrollo de marca y estrategia digital']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Influencer, estrategia y branding']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Seguridad y cultura social']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Estrategia social y desarrollo de marca']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Emprendimiento digital']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Influencer, tendencias y comunidad']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Moda, maquillaje y belleza']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Entrenamiento y fitness']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Multimedia y VLogging']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Gaming y Streaming']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Gamers y streaming ']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Minecraft y roblox']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Fornite y call of duty']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Leage of legends']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Streaming y podcast']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'Streaming y podcast profesional']);
        CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'YouTuber']);
        $category = CourseCategory::create(['course_area_id' => $area['id'], 'title' => 'Marca personal y storytelling']);
        //CourseSpecialization::create(['course_category_id' => $category['id'], 'title' => 'xxx']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
