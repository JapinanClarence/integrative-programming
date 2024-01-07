<?php

namespace api\admin;

use api\Controller;
use model\UserModel;
use model\GradesModel;
use model\FacultyModel;
use model\StudentModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/InstituteModel.php");
require_once(__DIR__ . "/../../model/GradesModel.php");
require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../../model/UserModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../Controller.php");

class Grades extends Controller
{
	public function __construct()
	{
		//verify user role
		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch ($requestMethod) {
			case "GET": {
					if (array_key_exists("id", $_GET) || !empty($_GET["id"])) {
						$this->show();
					}
					break;
				}
			default: {
					response(false, ["message" => "Request method: {$requestMethod} not allowed!"]);
					break;
				}
		}
	}
	public function show()
	{
		$userId = isset($_GET["id"]) ? $_GET["id"] : null;

		$studentId = StudentModel::findUserInfo($userId, "student_id");

		$subjects = GradesModel::find($studentId["student_id"], "student_id", true);



		if (!$subjects) {
			response(false, ["message" => "No subject enrolled"]);
			exit;
		}

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

		response(true, ["data" => $returnData]);
	}
}
new Grades();
