<?php

namespace api\admin;

use api\Controller;
use model\CourseModel;
use model\FacultyModel;
use model\InstituteModel;
use model\SchoolYearModel;
use model\StudentModel;
use model\SubjectModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/SubjectModel.php");
require_once(__DIR__ . "/../../model/InstituteModel.php");
require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../Controller.php");

class Dashboard extends Controller
{
	public function __construct()
	{

		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch ($requestMethod) {

			case "GET": {
					$this->dashBoardData();
					break;
				}

			default: {
					response(false, ["message" => "Request method: {$requestMethod} not allowed!"]);
					break;
				}
		}
	}
	public function dashBoardData()
	{
		$students = StudentModel::all(); //array
		$faculties = FacultyModel::all();
		$courses = CourseModel::all();
		$fcdset = StudentModel::find("FCDSET", "institute", true);
		$fgbm = StudentModel::find("FGBM", "institute", true);
		$fnahs = StudentModel::find("FNAHS", "institute", true);
		$fted = StudentModel::find("FTED", "institute", true);
		$fals = StudentModel::find("FALS", "institute", true);
		$totalCourses = CourseModel::read() == null ? 0 : count(CourseModel::read());
		$totalInstitute = InstituteModel::read() == null ? 0 : count(InstituteModel::read());
		$totalSubject = SubjectModel::read() == null ? 0 : count(SubjectModel::read());
		$schoolYear = SchoolYearModel::find("1", "status");

		$studentCount = $students == null ? 0 : count($students); //if null, returns 0 else count the lenght of the array
		$facultiesCount = $faculties == null ? 0 : count($faculties);
		$fcdsetCount = $fcdset == null ? 0 : count($fcdset);
		$fgbmCount = $fgbm == null ? 0 : count($fgbm);
		$fnahsCount = $fnahs == null ? 0 : count($fnahs);
		$ftedCount =  $fted == null ? 0 : count($fted);
		$falsCount = $fals == null ? 0 : count($fals);

		$studentCountByCourse = StudentModel::studentCountByCourse($courses);

		response(true, [
			"school_year" => $schoolYear["school_year"],
			"total_course" => $totalCourses,
			"total_institute" => $totalInstitute,
			"total_subject" => $totalSubject,
			"student_count" => $studentCount,
			"faculty_count" => $facultiesCount,
			"student_count_by_institute" => ["FCDSET" => $fcdsetCount, "FGBM" => $fgbmCount, "FNAHS" => $fnahsCount, "FALS" => $falsCount, "FTED" => $ftedCount],
			"student_count_by_course" => $studentCountByCourse
		]);
	}
}
new Dashboard();
