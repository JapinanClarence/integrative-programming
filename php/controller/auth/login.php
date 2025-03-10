<?php

namespace api;

use model\UserModel;

require_once(__DIR__ . "/../../model/UserModel.php");
require_once(__DIR__ . "/../Controller.php");

class Student extends Controller
{
	public function __construct()
	{
		$requestMethod = $_SERVER["REQUEST_METHOD"];

		switch ($requestMethod) {
			case "POST": {
					$this->login();
					break;
				}
			default: {
					response(false, ["message" => "Request method: {$requestMethod} not allowed!"]);
					break;
				}
		}
	}
	public function login()
	{
		$data = json_decode(file_get_contents("php://input"));
		$email = $data->email;
		$password = $data->password;


		Controller::verifyJsonData($data);

		$result = UserModel::find($email, "email");

		if (!$result || !password_verify($password, $result["password"])) {
			response(false, ["message" => "Invalid Credentials!"]);
			exit;
		}

		//trim the first word of the middlename
		$middlename = substr($result["middle_name"], 0, 1) . ".";
		$fullname = $result["first_name"] . " " . $middlename . " " . $result["last_name"];
		$responseData = [
			"message" => "Login successful",
			"user_id" => $result["user_id"],
			"username" => $fullname,
			"role" => $result["role"],
		];

		response(true, $responseData);
	}
}
new Student();
