<?php
namespace App\Interfaces;
use Symfony\Component\HttpFoundation\Request;


interface CustomerInterface{
  
  public function getAllCustomerList();

  public function getUserById($id);
  
  public function requestNewCustomer($id);

}
?>