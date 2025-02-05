<?php

namespace Controllers;

use DAO\KeeperDAO as KeeperDAO;
use DAO\ReserveDAO as ReserveDAO;

class KeeperController
{
    private $keeperDAO;
    private $reserveDAO;
    private $userLogged;

    public function __construct()
    {
        AuthController::validateLogged();
        AuthController::validateRole('Keeper');

        $this->keeperDAO = new KeeperDAO();
        $this->reserveDAO = new ReserveDAO();
        $this->userLogged = $_SESSION['user'];
    }

    public function ShowPerfil()
    {
        $keeper = $this->keeperDAO->SearchByUserId($this->userLogged->getId());
        require_once(VIEWS_PATH . "keeper/perfil.php");
    }


    public function Update($name, $lastName, $address, $startDate, $endDate, $days, $price)
=======
    public function Update($name, $lastname, $address, $startDate, $endDate, $days, $price)

    {
        try {

            $sizePet = array();
            if(isset($_POST['small'])){
                array_push($sizePet, 'Small');
            }
            if(isset($_POST['medium'])){
                array_push($sizePet, 'Medium');
            }
            if(isset($_POST['big'])){
                array_push($sizePet, 'Big');
            }

            $keeper = $this->keeperDAO->SearchByUserId($this->userLogged->getId());
            $keeper->setName($name);
            $keeper->setLastname($lastName);
            $keeper->setAddress($address);
            $keeper->setPrice($price);
            $keeper->setStartdate($startDate);
            $keeper->setEnddate($endDate);
            $keeper->setDays($days);
            $keeper->setSizePet($sizePet);

            if ($this->keeperDAO->Update($keeper)) {
                $_SESSION['success'] = 'Keeper updated';
            } else {
                $_SESSION['error'] = 'Keeper could not be updated';
            }
            
        } catch (\Throwable $th) {
            $_SESSION['error'] = 'Exception. ' . $th->getMessage();
        }
        $this->ShowPerfil();
    }

    public function ShowMyReserves(){
        $keeper = $this->keeperDAO->SearchByUserId($this->userLogged->getId());
        $reserves = $this->reserveDAO->GetAllByKeeper($keeper->getId());
        require_once(VIEWS_PATH . "keeper/my-reserves.php");
    }

    public function AcceptReserve($reserveId){        
        try {
            $reserve = $this->reserveDAO->Search($reserveId);
            $reserves = $this->reserveDAO->GetAllByRangeDate($reserve->getStartDate(), $reserve->getEndDate());

            foreach ($reserves as $item) {
                if($item->getPet()->getPetType()->getId() != $reserve->getPet()->getPetType()->getId()){
                    $_SESSION['error'] = 'You can not take care of different types of pets in the same day';
                    $this->ShowMyReserves();
                    return;
                }
            }

            if ($reserve->getState() == 'Waiting' && $this->reserveDAO->Accept($reserve)) {
                $_SESSION['success'] = 'Reserve accepted';
            } else {
                $_SESSION['error'] = 'Reserve could not be accepted';
            }

        } catch (\Throwable $th) {
            $_SESSION['error'] = 'Exception. ' . $th->getMessage();
        }
        $this->ShowMyReserves();
    }

    public function DeclineReserve($reserveId){        
        try {
            $reserve = $this->reserveDAO->Search($reserveId);          

            if ($reserve->getState() == 'Waiting' && $this->reserveDAO->Decline($reserve)) {
                $_SESSION['success'] = 'Reserve declined';
            } else {
                $_SESSION['error'] = 'Reserve could not be declined';
            }

        } catch (\Throwable $th) {
            $_SESSION['error'] = 'Exception. ' . $th->getMessage();
        }
        $this->ShowMyReserves();
    }
}
