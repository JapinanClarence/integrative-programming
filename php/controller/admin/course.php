<?php

namespace api\admin;

use api\Controller;
use model\CourseModel;
use model\StudentModel;

require_once(__DIR__ . "/../../model/CourseModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../Controller.php");

class Course extends Controller
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
					if (array_key_exists("action", $_GET) && $_GET["action"] === "course_institute") {
						$this->fetchCourseByInstitute();
					} else if (array_key_exists("id", $_GET) || !empty($_GET["id"])) {
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
		$title = $data->title;
		$slug = $data->slug;
		$description = $data->description;
		$institute = $data->institute;


		$result = CourseModel::create($title, $slug, $description, $institute);

		if (!$result) {
			response(false, ["message" => "Registration failed!"]);
			exit;
		} else {
			response(true, ["message" => "Registered successfully!"]);
		}
	}
	public function fetchCourseByInstitute()
	{
		$slug = isset($_GET["institute"]) ? $_GET["institute"] : null;

		$results = CourseModel::find($slug, "institute", true);

		if (!$results) {
			response(false, ["message" => "Course not found!"]);
			exit;
		}
		response(true, ["data" => $results]);
	}
	public function show()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = CourseModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "Course not found!"]);
			exit;
		}

		response(true, $results);
	}
	public function search()
	{
		$query = isset($_GET["query"]) ? $_GET["query"] : null;

		$results = CourseModel::search($query);

		if (!$results) {
			response(false, ["message" => "Course not found!"]);
			exit;
		}

		response(true, ["data" => $results]);
	}
	public function all()
	{
		$results = CourseModel::all();

		if (!$results) {
			response(false, ["message" => "No registered course currently"]);
			exit;
		}

		$numRows = count($results);

		foreach ($results as $result) {

			$returnData[] = [
				"id" => $result["id"],
				"title" => $result["title"],
				"slug" => $result["slug"],
				"description" => $result["description"],
				"institute" => $result["institute"]
			];
		}
		response(true, ["row_count" => $numRows, "data" => $returnData]);
	}
	public function update()
	{
		$data = json_decode(file_get_contents("php://input"));

		Controller::verifyJsonData($data);

		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		//set json data from request body
		$title = $data->title;
		$slug = $data->slug;
		$description = $data->description;
		$institute = $data->institute;

		if (!CourseModel::find($id, "id")) {
			response(false, ["message" => "Course not found!"]);
			exit;
		}

		$result = CourseModel::update($id, $title, $slug, $description, $institute);

		if (!$result) {
			response(false, ["message" => "Update failed!"]);
			exit;
		} else {
			response(true, ["message" => "Update successfull!"]);
		}
	}
	public function delete()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = CourseModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "Course not found!"]);
			exit;
		}

		//verify if student is enrolled in the course
		$studentByMajor = StudentModel::find($results["slug"], "course");

		if ($studentByMajor) {
			response(false, ["message" => "Students are enrolled in this course"]);
			exit;
		}

		if (CourseModel::delete($id, "id")) {
			response(true, ["message" => "Delete successful"]);
		} else {
			response(false, ["message" => "Delete Failed!"]);
		}
	}
}
new Course();
