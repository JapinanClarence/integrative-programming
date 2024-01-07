<?php

namespace api\admin;

use api\Controller;
use model\UserModel;
use model\CourseModel;
use model\GradesModel;
use model\FacultyModel;
use model\StudentModel;
use model\SchoolYearModel;
use model\FacultySubjectsModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../../model/FacultySubjectsModel.php");
require_once(__DIR__ . "/../../model/GradesModel.php");
require_once(__DIR__ . "/../../model/SchoolYearModel.php");
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
		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		$faculty = FacultyModel::fetchId($id, "user_id")["faculty_id"];

		$results = FacultySubjectsModel::find($faculty, "faculty_id", true);

		if (!$results) {
			response(false, ["message" => "No registered subjects currently"]);
			exit;
		}

		$schoolYear = SchoolYearModel::find("1", "status");
		$returnData = [];
		$totalStudents = 0;

		foreach ($results as $result) {
			// fetch handled students
			$handledStudents = GradesModel::where([
				"subject_code" => $result["subject_code"],
				"faculty_id" => $faculty
			], true);

			// count students by subjects
			$studentCountBySub = count($handledStudents);

			// add the count to returnData
			$returnData[$result["subject_code"]] = $studentCountBySub;

			// update total students count
			$totalStudents += $studentCountBySub;
		}

		// calculate the total number of subjects handled
		$totalSubjectsHandled = count($results);

		response(true, ["data" => $returnData, "total_students" => $totalStudents, "total_subjects_handled" => $totalSubjectsHandled, "school_year" => $schoolYear["school_year"]]);
	}
}
new Dashboard();
