<?php

namespace api\admin;

use api\Controller;
use model\FacultyModel;
use model\GradesModel;
use model\SchoolYearModel;
use model\StudentModel;
use model\UserModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/GradesModel.php");
require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../../model/UserModel.php");
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
		$userId = isset($_GET["id"]) ? $_GET["id"] : null;

		$studentId = StudentModel::findUserInfo($userId);

		$activeSchoolYear = SchoolYearModel::find("1", "status");

		$subjects = GradesModel::find($studentId["student_id"], "student_id", true);

		foreach ($subjects as $subject) {

			$faculty = FacultyModel::fetchId($subject["faculty_id"], "faculty_id");

			$facultyname = UserModel::find($faculty["user_id"], "user_id");

			//trim the first word of the middlename
			$middlename = substr($facultyname["middle_name"], 0, 1) . ".";
			$fullname = $facultyname["first_name"] . " " . $middlename . " " . $facultyname["last_name"];

			$returnData[] = [
				"subject_code" => $subject["subject_code"],
				"grades" => $subject["grades"],
				"created_at" => $subject["created_at"],
				"faculty" => $fullname
			];
		}

		response(true, ["active_school_year" => $activeSchoolYear["school_year"], "semester" => $activeSchoolYear["semester"], "subjects" => $returnData]);
	}
}
new Dashboard();
