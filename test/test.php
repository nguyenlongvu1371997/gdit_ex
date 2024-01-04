<?php   
require_once '../vendor/autoload.php';
use Faker\Factory;
$faker = Factory::create();
echo  $faker->date('M-d-Y');
?>