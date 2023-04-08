<?php
namespace App\Interfaces;
use Symfony\Component\HttpFoundation\Request;
use Faker\Guesser\Name;
interface SettingInterface
{

    public function create();
    public function store($request);

}

?>