<?php

namespace api\admin;

use api\Controller;
use model\UserModel;
use model\CourseModel;
use model\FacultyModel;
use model\InstituteModel;

require_once(__DIR__ . "/../../model/FacultyModel.php");
require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/InstituteModel.php");
require_once(__DIR__ . "/../../model/UserModel.php");
require_once(__DIR__ . "/../Controller.php");

class Faculty extends Controller
{
	public function __construct()
	{

		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch ($requestMethod) {
			case "POST": {
					$this->create();
					break;
				}
			case "GET": {
					if (array_key_exists("id", $_GET) || !empty($_GET["id"])) {
						$this->show();
					} else if (array_key_exists("query", $_GET) || !empty($_GET["query"])) {
						$this->search();
					} else {
						$this->all();
					}
					break;
				}
			case "PATCH": {
					$this->update();
					break;
				}
			case "DELETE": {
					$this->delete();
					break;
				}
			default: {
					response(false, ["message" => "Request method: {$requestMethod} not allowed!"]);
					break;
				}
		}
	}
	public function create()
	{
		$data = json_decode(file_get_contents("php://input"));

		Controller::verifyJsonData($data);

		//set json data from request body
		$firstname = $data->firstname;
		$lastname = $data->lastname;
		$middlename = $data->middlename;
		$birthday = $data->birthday;
		$gender = $data->gender;
		$email = $data->email;
		$contact = $data->contact;
		$course = $data->course;
		$institute = $data->institute;

		//verify if email is already taken
		$fetchEmail = UserModel::find($email, "email");
		if ($fetchEmail) {
			response(false, ["message" => "Email already taken"]);
			exit;
		}

		if (!CourseModel::find($course, "slug")) {
			response(false, ["message" => "Course does not exists"]);
			exit;
		}

		if (!InstituteModel::find($institute, "slug")) {
			response(false, ["message" => "Insitute does not exists"]);
			exit;
		}

		//default password
		$password = password_hash("dorsu_faculty", PASSWORD_DEFAULT);

		$result = FacultyModel::create($firstname, $lastname, $middlename, $birthday, $gender, $email, $contact, $institute, $course, $password, Controller::FACULTY_ROLE);

		if (!$result) {
			response(false, ["message" => "Registration failed!"]);
			exit;
		} else {
			response(true, ["message" => "Registered successfully!"]);
		}
	}
	public function show()
	{
		$facultyId = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = FacultyModel::find($facultyId, "faculty_id");

		if (!$results) {
			response(false, ["message" => "Faculty not found!"]);
			exit;
		}

		response(true, $results);
	}
	public function search()
	{
		$query = isset($_GET["query"]) ? $_GET["query"] : null;

		$results = FacultyModel::search($query);

		if (!$results) {
			response(false, ["message" => "Faculty not found!"]);
			exit;
		}

		response(true, ["data" => $results]);
	}
	public function all()
	{
		$results = FacultyModel::all();
		if (!$results) {
			response(false, ["message" => "No registered faculty currently"]);
			exit;
		}

		$numRows = count($results);

		response(true, ["row_count" => $numRows, "data" => $results]);
	}
	public function update()
	{
		$facultyId = isset($_GET["id"]) ? $_GET["id"] : null;

		$data = json_decode(file_get_contents("php://input"));

		Controller::verifyJsonData($data);

		//set json data from request body
		$firstname = $data->firstname;
		$lastname = $data->lastname;
		$middlename = $data->middlename;
		$birthday = $data->birthday;
		$gender = $data->gender;
		$email = $data->email;
		$contact = $data->contact;
		$course = $data->course;
		$institute = $data->institute;

		$faculty = FacultyModel::find($facultyId, "faculty_id");

		if (!$faculty) {
			response(false, ["message" => "Faculty not found!"]);
			exit;
		}

		if (!CourseModel::find($course, "slug")) {
			response(false, ["message" => "Course does not exists"]);
			exit;
		}

		if (!InstituteModel::find($institute, "slug")) {
			response(false, ["message" => "Insitute does not exists"]);
			exit;
		}

		$result = FacultyModel::update($facultyId, $faculty["user_id"], $firstname, $lastname, $middlename, $birthday, $gender, $email, $contact, $institute, $course);

		if (!$result) {
			response(false, ["message" => "Update failed!"]);
			exit;
		} else {
			response(true, ["message" => "Updated successfully!"]);
		}
	}
	public function delete()
	{
		$facultyId = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = FacultyModel::find($facultyId, "faculty_id");

		if (!$results) {
			response(false, ["message" => "Faculty not found!"]);
			exit;
		}

		if (UserModel::delete($results["user_id"], "user_id")) {
			response(true, ["message" => "Delete successful"]);
		} else {
			response(false, ["message" => "Delete Failed!"]);
		}
	}
}
new Faculty();
