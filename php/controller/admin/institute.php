<?php

namespace api\admin;

use api\Controller;
use model\StudentModel;
use model\InstituteModel;

require_once(__DIR__ . "/../../model/InstituteModel.php");
require_once(__DIR__ . "/../../model/StudentModel.php");
require_once(__DIR__ . "/../Controller.php");

class Institute extends Controller
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
		$title = $data->title;
		$slug = $data->slug;
		$description = $data->description;

		$result = InstituteModel::create($title, $slug, $description);

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

		$results = InstituteModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "Institute not found!"]);
			exit;
		}

		response(true, $results);
	}
	public function search()
	{
		$query = isset($_GET["query"]) ? $_GET["query"] : null;

		$results = InstituteModel::search($query);

		if (!$results) {
			response(false, ["message" => "Institute not found!"]);
			exit;
		}

		response(true, ["data" => $results]);
	}
	public function all()
	{
		$results = InstituteModel::all();

		if (!$results) {
			response(false, ["message" => "No registered institute currently"]);
			exit;
		}

		$numRows = count($results);

		foreach ($results as $result) {

			$returnData[] = [
				"id" => $result["id"],
				"title" => $result["title"],
				"slug" => $result["slug"],
				"description" => $result["description"]
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


		if (!InstituteModel::find($id, "id")) {
			response(false, ["message" => "Institute not found!"]);
			exit;
		}

		$result = InstituteModel::update($id, $title, $slug, $description);

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

		$results = InstituteModel::find($id, "id");

		if (!$results) {
			response(false, ["message" => "Institute not found!"]);
			exit;
		}
		//verify if student is enrolled in the institute
		$studentByMajor = StudentModel::find($results["slug"], "institute");

		if ($studentByMajor) {
			response(false, ["message" => "Students are enrolled in this institute"]);
			exit;
		}


		if (InstituteModel::delete($id, "id")) {
			response(true, ["message" => "Delete successful"]);
		} else {
			response(false, ["message" => "Delete Failed!"]);
		}
	}
}
new Institute();
