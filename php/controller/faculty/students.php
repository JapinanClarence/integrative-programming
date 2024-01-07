<?php

namespace api\admin;

use api\Controller;
use model\CourseModel;
use model\FacultyModel;
use model\GradesModel;
use model\InstituteModel;
use model\StudentModel;
use model\UserModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/InstituteModel.php");
require_once(__DIR__ . "/../../model/UserModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../../model/GradesModel.php");
require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../Controller.php");

class Student extends Controller
{
	public function __construct()
	{
		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch ($requestMethod) {
			case "GET": {
					if (array_key_exists("id", $_GET) || !empty($_GET["id"])) {
						$this->show();
					} else if (array_key_exists("faculty_id", $_GET) || !empty($_GET["faculty_id"])) {
						$this->all();
					}
					break;
				}
			default: {
					response(false, ["message" => "Request method: {$requestMethod} not allowed!"]);
					break;
				}
		}
	}
	public function all()
	{
		$faculty = isset($_GET["faculty_id"]) ? $_GET["faculty_id"] : null;

		$facultyId = FacultyModel::find($faculty, "user_id");

		$students = GradesModel::find($facultyId["faculty_id"], "faculty_id", true);

		if (!$students) {
			response(false, ["message" => "No registered students currently"]);
			exit;
		}

		foreach ($students as $student) {
			$studentInfo = StudentModel::find($student["student_id"], "student_id");
			$studentInfo["grade"] = $student["grades"];

			$results[] = $studentInfo;
		}

		$numRows = count($results);

		response(true, ["row_count" => $numRows, "data" => $results]);
	}
	public function show()
	{
		$studentId = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = StudentModel::find($studentId, "student_id");

		$grades = GradesModel::find($studentId, "student_id", true);

		if (!$grades) {
			response(false, ["message" => "No enrolled subjects"]);
			exit;
		}

		$totalGrade = 0; // Initialize totalGrade to 0

		foreach ($grades as $grade) {

			$totalGrade += $grade["grades"]; // Accumulate grades for total calculation
		}

		// Assuming $grades is an array, use count($grades) to get the number of subjects
		$numberOfSubjects = count($grades);

		// Calculate the average grade
		$averageGrade = $numberOfSubjects > 0 ? $totalGrade / $numberOfSubjects : 0;

		$responseData = $results;
		// If you want to keep the total grade and average grade in the response, you can do this:
		$responseData["total_grade"] = $totalGrade;
		$responseData["average_grade"] = $averageGrade;

		response(true, $responseData);
	}
}
new Student();
