<?php

namespace App\Controllers;

use Flight;
use App\Services\SportsApiService;
use InvalidArgumentException;

class ApiController {
    private $sportsApiService;

    public function __construct(SportsApiService $sportsApiService) {
        $this->sportsApiService = $sportsApiService;
    }

    /**
     * Retorna as ligas de um país específico.
     *
     * @param string $country O país para filtrar as ligas.
     */
    public function getLeaguesByCountry(string $country) {

        try {
            if (empty($country)) {
                return Flight::json(["erro" => 'O código do país deve ser um valor válido.'], 400);
            }

            $data = $this->sportsApiService->getLeaguesByCountry($country);

            Flight::json(["data" => $data]);

        } catch (InvalidArgumentException $e) {

            Flight::json(["error" => $e->getMessage()], 400);

        } catch (\Exception $e) {

            Flight::json(["error" => $e->getMessage()], 500);

        }
    }

    /**
     * Retorna as ligas de um time específico.
     *
     * @param int $id O ID do time.
     */
    public function getLeaguesByTeam(int $id) {
        try {
            if ($id <= 0) {
                throw new InvalidArgumentException("O ID do time deve ser um número positivo.");
            }

            $data = $this->sportsApiService->getLeaguesByTeam($id);
            Flight::json(["data" => $data]);
        } catch (InvalidArgumentException $e) {
            Flight::json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Flight::json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna informações sobre uma liga específica.
     *
     * @param int $id O ID da liga.
     * @param int $ano O ano da temporada.
     * @param int $rodada A rodada da temporada.
     */
    public function getLeagueDetails(int $id, int $ano, int $rodada) {
        try {
            if ($id <= 0) {
                return Flight::json(["erro" => 'O ID da liga deve ser um número positivo.'], 400);
            }

            $currentYear = date('Y');
            if ($ano < 2018 || $ano > $currentYear) {
                return Flight::json(["erro" => "O ano deve estar entre 2018 e $currentYear."], 400);
            }

            if ($rodada <= 0) {
                return Flight::json(["erro" => 'A rodada deve ser um número positivo.'], 400);
            }

            $rodada = "Regular Season - {$rodada}";
            $jogos = $this->sportsApiService->getFixtures($id, $ano, $rodada);
            $classificacao = $this->sportsApiService->getStandings($id, $ano);

            Flight::json([
                "data" => [
                    "jogos" => $jogos ?? [],
                    "classificacao" => $classificacao ?? [],
                ]
            ]);
        } catch (InvalidArgumentException $e) {
            Flight::json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Flight::json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna a lista de países.
     */
    public function getCountries() {
        try {
            $data = $this->sportsApiService->getCountries();
            Flight::json(["data" => $data]);
        } catch (\Exception $e) {
            Flight::json(["error1" => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna os times de um país específico.
     *
     * @param string $country O país para filtrar os times.
     */
    public function getTeamsByCountry(string $country) {
        try {
            if (empty($country)) {
                return Flight::json(["erro" => 'O nome do país deve ser um nome válido.'], 400);
            }

            $data = $this->sportsApiService->getTeamsByCountry($country);
            Flight::json(["data" => $data]);
        } catch (InvalidArgumentException $e) {
            Flight::json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Flight::json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna informações sobre um time específico.
     *
     * @param string $id O ID do time.
     */
    public function getTeamById(int $id) {
        try {
            // Validação: ID deve ser um número inteiro positivo
            if ($id <= 0) {
                return Flight::json(["erro" => 'O ID do time deve ser um número positivo.'], 400);
            }

            $data = $this->sportsApiService->getTeamById($id);
            Flight::json(["data" => $data]);
        } catch (InvalidArgumentException $e) {
            Flight::json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Flight::json(["error" => $e->getMessage()], 500);
        }
    }

    /**
     * Retorna estatísticas de uma liga e time específicos.
     *
     * @param int $id O ID da liga.
     * @param int $team O ID do time.
     * @param int $ano O ano da temporada.
     */
    public function getTeamStatistics(int $id, int $team, int $ano) {
        try {
            if ($id <= 0 || $team <= 0) {
                return Flight::json(["erro" => 'Os IDs da liga e do time devem ser um número positivo.'], 400);
            }

            $currentYear = date('Y');
            if ($ano < 2018 || $ano > $currentYear) {
                return Flight::json(["erro" => "O ano deve estar entre 2018 e $currentYear."], 400);
            }

            $data = $this->sportsApiService->getStatistics($id, $team, $ano);
            Flight::json(["data" => $data]);
        } catch (InvalidArgumentException $e) {
            Flight::json(["error" => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Flight::json(["error" => $e->getMessage()], 500);
        }
    }
}