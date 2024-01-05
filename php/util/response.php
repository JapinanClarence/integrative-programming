<?php
// response(200, true, ["username" => "clarence", "email" => "japinanclarence@gmail.com", "skills" => ["drawing", "singing", "dancing"]]);

function response(bool $success, $data = [])
{
	$responseData = [];

	//set reponse data
	$responseData["success"]  = $success;
	foreach ($data as $key => $value) {
		$responseData[$key] = $value;
	}

	echo json_encode($responseData);
}
