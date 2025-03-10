<?php

namespace model;

use database\Database;
use PDOException;

require_once(__DIR__ . "/../database/Database.php");

class SubjectModel
{
	private const TABLE = "subjects";

	/**
	 * Perform insert operation to the database
	 * @return true if success
	 */
	public static function create(
		$code,
		$description,
		$unit,
		$type,
		$schoolYear,
		$status
	) {
		try {
			$query = "INSERT INTO " . self::TABLE . " SET code = :code, description = :description, unit = :unit, type = :type, status = :status, school_year = :schoolYear";

			$stmt = Database::connect()->prepare($query);

			$stmt->bindParam(":code", $code);
			$stmt->bindParam(":description", $description);
			$stmt->bindParam(":unit", $unit);
			$stmt->bindParam(":type", $type);
			$stmt->bindParam(":schoolYear", $schoolYear);
			$stmt->bindParam(":status", $status);

			$result = $stmt->execute() ? true : false;
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	public static function read()
	{
		try {
			$query = "SELECT * FROM " . self::TABLE;

			$stmt = Database::connect()->prepare($query);

			$stmt->execute();

			$rowCount = $stmt->rowCount();

			if ($rowCount == 0) {
				return null;
			}

			$result = $stmt->fetchAll();

			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	/**
	 * Perform fetch operation strictly  based on the condition
	 * @return null if condition is not found
	 * @return array result
	 */
	public static function find($column, $condition, $fetchAll = false)
	{
		try {
			//query statement
			$query = "SELECT * FROM " . self::TABLE . " WHERE $condition = :$condition";

			//prepared statement
			$stmt = Database::connect()->prepare($query);

			$stmt->bindParam(":$condition", $column);
			$stmt->execute();
			//verifies if there's a returned value
			if ($stmt->rowCount() == 0) {
				return null;
				exit;
			}
			//fetch and return result
			if ($fetchAll === true) {
				$result = $stmt->fetchAll();
			} else {
				$result = $stmt->fetch();
			}
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	/**
	 * Perform fetch operation based on the condition
	 * @return null if condition is not found
	 * @return array result
	 */
	public static function search($column)
	{
		try {
			//query statement
			$query = "SELECT * FROM " . self::TABLE . " WHERE code LIKE :code OR description LIKE :description";

			//prepared statement
			$stmt = Database::connect()->prepare($query);

			$searchPattern = "%" . $column . "%";

			$stmt->bindParam(":code", $searchPattern);
			$stmt->bindParam(":description", $searchPattern);

			$stmt->execute();
			//verifies if there's a returned value
			if ($stmt->rowCount() == 0) {
				return null;
				exit;
			}
			//fetch and return result
			$result = $stmt->fetchAll();
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	/**
	 * Fetch all data from resource
	 *
	 */
	public static function all()
	{
		try {
			//query statement
			$query = "SELECT * FROM " . self::TABLE;
			//prepared statement
			$stmt = Database::connect()->prepare($query);

			$stmt->execute();
			//verifies if there's a returned value
			if ($stmt->rowCount() == 0) {
				return null;
				exit;
			}
			//fetch and return result
			$result = $stmt->fetchAll();
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	/**
	 * Update data set based on the condition
	 * @return bool true if successul
	 */
	public static function update(
		$code,
		$description,
		$unit,
		$type,
	) {
		try {
			$query = "UPDATE " . self::TABLE . " SET  description = :description, unit = :unit, type = :type WHERE code = :code";

			$stmt = Database::connect()->prepare($query);

			$stmt->bindParam(":code", $code);
			$stmt->bindParam(":description", $description);
			$stmt->bindParam(":unit", $unit);
			$stmt->bindParam(":type", $type);

			$result = $stmt->execute() ? true : false;
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	/**
	 * Delete data on the database
	 * @return bool true if successful
	 */
	public static function delete($column, $condition)
	{
		try {
			//query statement
			$query = "DELETE FROM " . self::TABLE . " WHERE $condition = :$condition";
			//prepared statement
			$stmt = Database::connect()->prepare($query);

			$stmt->bindParam(":$condition", $column);


			$result = $stmt->execute() ? true : false;

			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
	//*NOTE
	//Update subject status based on the school year
	//
	public static function setSubjectStatus($schoolyear, $status)
	{
		try {
			$query = "UPDATE " . self::TABLE . " SET status = :status WHERE school_year = :schoolyear";

			$stmt = Database::connect()->prepare($query);

			$stmt->bindParam(":schoolyear", $schoolyear);
			$stmt->bindParam(":status", $status);

			$result = $stmt->execute() ? true : false;
			return $result;
		} catch (PDOException $e) {
			$response = [
				"message" => "Error: {$e->getMessage()} on line {$e->getLine()}"
			];
			response(false, $response);
			exit;
		}
	}
}
