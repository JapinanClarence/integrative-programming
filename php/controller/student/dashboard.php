<?php

namespace api\admin;

use api\Controller;
use model\FacultyModel;
use model\GradesModel;
use model\SchoolYearModel;
use model\StudentModel;
use model\SubjectModel;
use model\UserModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/GradesModel.php");
require_once(__DIR__ . "/../../model/SubjectModel.php");
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

			$subject = SubjectModel::find($subject["subject_code"], "code");

			$returnData[] = [
				"subject_code" => $subject["code"],
				"description" => $subject["description"],
				"unit" => $subject["unit"],
				"type" => $subject["type"],
				"created_at" => $subject["created_at"]
			];
		}

		response(true, ["active_school_year" => $activeSchoolYear["school_year"], "semester" => $activeSchoolYear["semester"], "subjects" => $returnData]);
	}
}
new Dashboard();
