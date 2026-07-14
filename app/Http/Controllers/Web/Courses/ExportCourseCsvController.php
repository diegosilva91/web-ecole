<?php

namespace App\Http\Controllers\Web\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lifecole\Api\Domain\Adapter\CdnAdapter;

class ExportCourseCsvController extends Controller
{
    public function exportCsv(Request $request, CdnAdapter $cdnAdapter)
    {
        $fileName = 'courses.csv';
        $courses = Course::with('categories', 'courseUsers', 'teachers', 'promotions')->ListCoursesFilters(true)->get();
        $headers = array(
            'Content-Encoding' => 'UTF-8',
            "Content-type" => " text/csv; charset=UTF-8; application/vnd.ms-excel",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            'Content-Transfer-Encoding' => 'binary',
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Program ID', 'Program Name', 'School Name', 'Final URL', 'Image URL', 'Area of Study', 'Program description', 'URL', 'Similar Program IDs');

        $callback = function () use ($courses, $columns, $cdnAdapter) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, $columns);
            foreach ($courses as $course) {
                $row['Program ID'] = $course->id;
                $row['Program Name'] = $course->title;
                $row['School Name'] = 'Lifecole | ' . $course->courseUsers[0]->name;
                $row['Final URL'] = $course->getLink();
                $row['Image URL'] = $cdnAdapter->image($course->cover_image);
                $row['Area of Study'] = '' . $course->categories->title;
                $row['Program description'] = $course->intro;
                $row['URL'] = $course->getLink();
                $row['Similar Program IDs'] = $course->getSameCategories('id')->implode(",");

                fputcsv($file, [$row['Program ID'], $row['Program Name'], $row['School Name'], $row['Final URL'],// $row['Thumbnail'],
                    $row['Image URL'], $row['Area of Study'], $row['Program description'], $row['URL'], $row['Similar Program IDs']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
