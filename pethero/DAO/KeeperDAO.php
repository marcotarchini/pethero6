<?php

namespace DAO;

use DAO\IKeeperDAO as IKeeperDAO;
use Models\Keeper as Keeper;

use DAO\UserDAO as UserDAO;
use Exception;

class KeeperDAO implements IKeeperDAO
{
    private $connection;
    private $tableName = "keepers";

    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    private function ArrayToString($array)
    {
        $string = '';
        foreach ($array as $item) {
            $string = $string . $item . ',';
        }
        if ($string == '') {
            return $string;
        }
        return substr($string, 0, strlen($string) - 1);
    }

    private function StringToArray($string)
    {
        return explode(',', $string);
    }

    public function Add(Keeper $keeper)
    {
        try {

            $query = "INSERT INTO " . $this->tableName . " (id, name, lastname, address, sizePet, price, startDate, endDate, days, userId) VALUES (:id, :name, :lastname, :address, :sizePet, :price, :startDate, :endDate, :days, :userId);";
            $parameters["id"] = 0;
            $parameters["name"] = $keeper->getName();
            $parameters["lastname"] = $keeper->getLastname();
            $parameters["address"] = $keeper->getAddress();
            $parameters["sizePet"] = $this->ArrayToString($keeper->getSizepet());
            $parameters["price"] = $keeper->getPrice();
            $parameters["startDate"] = $keeper->getStartdate();
            $parameters["endDate"] = $keeper->getEnddate();
            $parameters["days"] = $keeper->getDays();
            $parameters["userId"] = $keeper->getUser()->getId();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
        return false;
    }

    public function Update(Keeper $keeper)
    {
        try {

            $query = "UPDATE " . $this->tableName . " SET name=:name, lastname=:lastname, address=:address, sizePet=:sizePet, price=:price, startDate=:startDate, endDate=:endDate, days=:days WHERE id=:id";
            $parameters["id"] = $keeper->getId();
            $parameters["name"] = $keeper->getName();
            $parameters["lastname"] = $keeper->getLastname();
            $parameters["address"] = $keeper->getAddress();
            $parameters["sizePet"] = $this->ArrayToString($keeper->getSizepet());
            $parameters["price"] = $keeper->getPrice();
            $parameters["startDate"] = $keeper->getStartdate();
            $parameters["endDate"] = $keeper->getEnddate();
            $parameters["days"] = $keeper->getDays();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
        return false;
    }

    public function Search($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $keeper = new Keeper();
                $keeper->setId($row["id"]);
                $keeper->setName($row["name"]);
                $keeper->setLastname($row["lastname"]);
                $keeper->setAddress($row["address"]);
                $keeper->setSizePet($this->StringToArray($row["sizePet"]));
                $keeper->setPrice($row["price"]);
                $keeper->setStartDate($row["startDate"]);
                $keeper->setEndDate($row["endDate"]);
                $keeper->setDays($row["days"]);
                $keeper->setUser($this->userDAO->Search($row["userId"]));

                return $keeper;
            }

            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function SearchByUserId($userId)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE userId = :userId";
            $parameters["userId"] = $userId;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $keeper = new Keeper();
                $keeper->setId($row["id"]);
                $keeper->setName($row["name"]);
                $keeper->setLastname($row["lastname"]);
                $keeper->setAddress($row["address"]);
                $keeper->setSizePet($this->StringToArray($row["sizePet"]));
                $keeper->setPrice($row["price"]);
                $keeper->setStartDate($row["startDate"]);
                $keeper->setEndDate($row["endDate"]);
                $keeper->setDays($row["days"]);
                $keeper->setUser($this->userDAO->Search($row["userId"]));

                return $keeper;
            }

            return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $keeperList = array();

            $query = "SELECT * FROM " . $this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $keeper = new Keeper();
                $keeper->setId($row["id"]);
                $keeper->setName($row["name"]);
                $keeper->setLastname($row["lastname"]);
                $keeper->setAddress($row["address"]);
                $keeper->setSizePet($this->StringToArray($row["sizePet"]));
                $keeper->setPrice($row["price"]);
                $keeper->setStartDate($row["startDate"]);
                $keeper->setEndDate($row["endDate"]);
                $keeper->setDays($row["days"]);
                $keeper->setUser($this->userDAO->Search($row["userId"]));

                array_push($keeperList, $keeper);
            }

            return $keeperList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAllByDate($startDate, $endDate)
    {
        try {
            $keeperList = array();
            $parameters = [];

            if ($startDate == null) {
                $query = "SELECT * FROM " . $this->tableName . " WHERE :endDate BETWEEN startDate AND endDate";
                $parameters["endDate"] = $endDate;
            } else if ($endDate == null) {
                $query = "SELECT * FROM " . $this->tableName . " WHERE :startDate BETWEEN startDate AND endDate";
                $parameters["startDate"] = $startDate;
            }else{
                $query = "SELECT * FROM " . $this->tableName . " WHERE startDate <= :startDate AND endDate >= :endDate";
                $parameters["startDate"] = $startDate;
                $parameters["endDate"] = $endDate;
            }

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $keeper = new Keeper();
                $keeper->setId($row["id"]);
                $keeper->setName($row["name"]);
                $keeper->setLastname($row["lastname"]);
                $keeper->setAddress($row["address"]);
                $keeper->setSizePet($this->StringToArray($row["sizePet"]));
                $keeper->setPrice($row["price"]);
                $keeper->setStartDate($row["startDate"]);
                $keeper->setEndDate($row["endDate"]);
                $keeper->setDays($row["days"]);
                $keeper->setUser($this->userDAO->Search($row["userId"]));

                array_push($keeperList, $keeper);
            }

            return $keeperList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
