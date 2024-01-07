<?php

namespace api\admin;

use api\Controller;
use model\SchoolYearModel;
use model\SubjectModel;

require_once(__DIR__ . "/../../model/SchoolYearModel.php");
require_once(__DIR__ . "/../../model/SubjectModel.php");
require_once(__DIR__ . "/../Controller.php");

class SchoolYear extends Controller
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
		$schoolYear = $data->schoolYear;
		$semester = $data->semester;

		$result = SchoolYearModel::create($schoolYear, $semester);

		if (!$result) {
			response(false, ["message" => "Registration failed!"]);
			exit;
		} else {
			response(true, ["message" => "Registered successfully!"]);
		}
	}
	public function show()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = SchoolYearModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "School year not found!"]);
			exit;
		}

		response(true, $results);
	}
	public function search()
	{
		$query = isset($_GET["query"]) ? $_GET["query"] : null;

		$results = SchoolYearModel::search($query);

		if (!$results) {
			response(false, ["message" => "School year not found!"]);
			exit;
		}

		response(true, ["data" => $results]);
	}
	public function all()
	{
		$results = SchoolYearModel::all();

		if (!$results) {
			response(false, ["message" => "No registered school year currently"]);
			exit;
		}

		$numRows = count($results);

		response(true, ["row_count" => $numRows, "data" => $results]);
	}
	public function update()
	{
		$data = json_decode(file_get_contents("php://input"));

		Controller::verifyJsonData($data);

		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		//set json data from request body
		$schoolYear = $data->schoolYear;
		$semester = $data->semester;
		$status = $data->status;


		if (!SchoolYearModel::find($id, "id")) {
			response(false, ["message" => "School year not found!"]);
			exit;
		}

		$schoolyear_update = SchoolYearModel::update($id, $schoolYear, $semester, $status);

		//update subject status if subject exists
		if (SubjectModel::find($schoolYear, "school_year")) {
			SubjectModel::setSubjectStatus($id, $status);
		}

		if (!$schoolyear_update) {
			response(false, ["message" => "Update failed!"]);
			exit;
		} else {
			response(true, ["message" => "Update successfull!"]);
		}
	}
	public function delete()
	{
		$id = isset($_GET["id"]) ? $_GET["id"] : null;

		$results = SchoolYearModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "School year not found!"]);
			exit;
		}

		if (SchoolYearModel::delete($id, "id")) {
			response(true, ["message" => "Delete successful"]);
		} else {
			response(false, ["message" => "Delete Failed!"]);
		}
	}
}
new SchoolYear();
