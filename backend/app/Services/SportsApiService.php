<?php

namespace App\Services;

use App\Utils\Utils;

class SportsApiService {
    private $apiUrl;
    private $apiKey;

    public function __construct() {
        $this->apiUrl = $_ENV['API_SPORTS'];
        $this->apiKey = $_ENV['API_KEY_SPORTS'];
    }

    public function getLeaguesByCountry(?string $country) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', 'leagues?country='.$country);
    }

    public function getLeaguesByTeam(int $id) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', 'leagues?team='.$id);
    }

    public function getFixtures(int $id, int $ano, string $rodada) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', "fixtures?league={$id}&season={$ano}&round={$rodada}");
    }

    public function getStandings(int $id, int $ano) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', "standings?league={$id}&season={$ano}");
    }

    public function getCountries() {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', 'countries');
    }

    public function getTeamsByCountry(string $country) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', "teams?country={$country}");
    }

    public function getTeamById(string $id) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', "teams?id={$id}");
    }

    public function getStatistics(int $id, int $team, int $ano) {
        return Utils::call($this->apiUrl, $this->apiKey, 'GET', "league={$id}&team={$team}&season={$ano}");
    }
}