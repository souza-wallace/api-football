<?php

require 'vendor/autoload.php';

use App\Controllers\ApiController;
use App\Services\SportsApiService;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$apiController = new ApiController(new SportsApiService());


Flight::route('OPTIONS *', function() {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");
  http_response_code(200);
  exit();
});

Flight::before('start', function() {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization");
});

// Ligas
Flight::route('/leagues/country/@country', [$apiController, 'getLeaguesByCountry']); // Ligas por país
Flight::route('/leagues/team/@id', [$apiController, 'getLeaguesByTeam']); // Ligas de um time específico
Flight::route('/leagues/@id/season/@year/round/@round', [$apiController, 'getLeagueDetails']); // Detalhes da liga

// // Países
Flight::route('/countries', [$apiController, 'getCountries']); // Lista todos os países

// // Times
Flight::route('/teams/country/@country', [$apiController, 'getTeamsByCountry']); // Times por país
Flight::route('/teams/@id', [$apiController, 'getTeamById']); // Detalhes de um time
Flight::route('/teams/@id/statistics/season/@season/league/@league', [$apiController, 'getTeamStatistics']); // Estatísticas do time

Flight::start();