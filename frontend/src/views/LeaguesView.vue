<template>
  <div>
    <NavBar />
    <div class="container mt-4">
      <div class="card p-4 shadow-sm">
        <div class="row g-3 align-items-end">
          <!-- Selecionar País -->
          <div class="col-md-3">
            <label class="form-label">País</label>
            <select class="form-select" v-model="country" @change="getLeaguesByCountry">
              <option value="" disabled selected>Selecione o país</option>
              <option :value="c.name" v-for="(c, index) in countries" :key="index">{{ c.name }}</option>
            </select>
          </div>
          <!-- Campo de busca -->
          <div class="col-md-6">
            <input class="form-control" type="search" placeholder="Busque por um campeonato" aria-label="Busque por um time" v-model="searchQuery" @input="searchTeam" :disabled="country">
          </div>
          <!-- Botão Pesquisar -->
          <div class="col-md-2 text-end">
            <button class="btn btn-primary w-100">Pesquisar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Lista de Times -->
    <div class="container mt-5">
      <h5 class="mb-4">Campeonatos: </h5>
      <div class="row" v-if="leagues.length != 0">
        <div class="col-md-3 mb-4" v-for="(t, index) in paginatedLeagues" :key="index">
          <router-link to="" class="border">
            <div class="card d-flex flex-column align-items-center p-3">
              <div class="d-flex justify-content-center w-100">
                <img :src="t.league.logo" class="card-img-top" alt="league Emblem" style="height: 100px; width: auto; object-fit: contain;">
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">{{ t.league.name }}</h5>
              </div>
            </div>
          </router-link> 
        </div>
      </div>
      <div class="text-center mt-3" v-if="paginatedLeagues.length < leagues.length">
        <button class="btn btn-secondary" @click="loadMore">Ver Mais</button>
      </div>
    </div>
  </div>
</template>
<script>
import NavBar from '../components/NavBar.vue';

export default {
  components: {
    NavBar
  },

  data() {
    return {
      leagues: [
      {
        "league": {
          "id": 71,
          "name": "Serie A",
          "type": "League",
          "logo": "https:\/\/media.api-sports.io\/football\/leagues\/71.png"
        },
        "country": {
          "name": "Brazil",
          "code": "BR",
          "flag": "https:\/\/media.api-sports.io\/flags\/br.svg"
        },
        "seasons": [
          {
            "year": 2010,
            "start": "2010-05-08",
            "end": "2010-11-28",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2011,
            "start": "2011-05-21",
            "end": "2011-12-04",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2012,
            "start": "2012-05-19",
            "end": "2012-12-02",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2013,
            "start": "2013-05-25",
            "end": "2013-12-08",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2014,
            "start": "2014-04-19",
            "end": "2014-12-07",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2015,
            "start": "2015-05-09",
            "end": "2015-12-06",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2016,
            "start": "2016-05-14",
            "end": "2016-12-11",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2017,
            "start": "2017-05-13",
            "end": "2017-12-03",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2018,
            "start": "2018-04-14",
            "end": "2018-12-02",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2019,
            "start": "2019-04-27",
            "end": "2019-12-08",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2020,
            "start": "2020-08-08",
            "end": "2021-02-26",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2021,
            "start": "2021-05-29",
            "end": "2021-12-10",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2022,
            "start": "2022-04-10",
            "end": "2022-11-13",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2023,
            "start": "2023-04-15",
            "end": "2023-12-03",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2024,
            "start": "2024-04-13",
            "end": "2024-12-08",
            "current": true,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": true,
              "predictions": true,
              "odds": false
            }
          }
        ]
      },
      {
        "league": {
          "id": 72,
          "name": "Serie B",
          "type": "League",
          "logo": "https:\/\/media.api-sports.io\/football\/leagues\/72.png"
        },
        "country": {
          "name": "Brazil",
          "code": "BR",
          "flag": "https:\/\/media.api-sports.io\/flags\/br.svg"
        },
        "seasons": [
          {
            "year": 2012,
            "start": "2012-05-19",
            "end": "2012-11-24",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2013,
            "start": "2013-05-24",
            "end": "2013-11-30",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2014,
            "start": "2014-04-18",
            "end": "2014-11-29",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2015,
            "start": "2015-05-08",
            "end": "2015-11-28",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2016,
            "start": "2016-05-13",
            "end": "2016-11-26",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2017,
            "start": "2017-05-12",
            "end": "2017-11-25",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2018,
            "start": "2018-04-13",
            "end": "2018-11-24",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2019,
            "start": "2019-04-26",
            "end": "2019-11-30",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2020,
            "start": "2020-08-07",
            "end": "2021-01-30",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2021,
            "start": "2021-05-28",
            "end": "2021-11-28",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2022,
            "start": "2022-04-09",
            "end": "2022-11-05",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2023,
            "start": "2023-04-14",
            "end": "2023-11-25",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2024,
            "start": "2024-04-19",
            "end": "2024-11-26",
            "current": true,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          }
        ]
      },
      {
        "league": {
          "id": 75,
          "name": "Serie C",
          "type": "League",
          "logo": "https:\/\/media.api-sports.io\/football\/leagues\/75.png"
        },
        "country": {
          "name": "Brazil",
          "code": "BR",
          "flag": "https:\/\/media.api-sports.io\/flags\/br.svg"
        },
        "seasons": [
          {
            "year": 2012,
            "start": "2012-06-30",
            "end": "2012-12-01",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2013,
            "start": "2013-06-01",
            "end": "2013-12-01",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2014,
            "start": "2014-04-26",
            "end": "2014-11-22",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2015,
            "start": "2015-05-16",
            "end": "2015-11-21",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2016,
            "start": "2016-05-21",
            "end": "2016-11-05",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2017,
            "start": "2017-05-13",
            "end": "2017-10-21",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2018,
            "start": "2018-04-14",
            "end": "2018-09-22",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2019,
            "start": "2019-04-27",
            "end": "2019-10-06",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2020,
            "start": "2020-08-08",
            "end": "2021-01-30",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2021,
            "start": "2021-05-29",
            "end": "2021-11-20",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2022,
            "start": "2022-04-09",
            "end": "2022-10-08",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2023,
            "start": "2023-05-02",
            "end": "2023-10-22",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2024,
            "start": "2024-04-20",
            "end": "2024-10-19",
            "current": true,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": true,
                "statistics_players": true
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          }
        ]
      },
      {
        "league": {
          "id": 76,
          "name": "Serie D",
          "type": "League",
          "logo": "https:\/\/media.api-sports.io\/football\/leagues\/76.png"
        },
        "country": {
          "name": "Brazil",
          "code": "BR",
          "flag": "https:\/\/media.api-sports.io\/flags\/br.svg"
        },
        "seasons": [
          {
            "year": 2012,
            "start": "2012-06-23",
            "end": "2012-10-21",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2013,
            "start": "2013-06-01",
            "end": "2013-11-03",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2014,
            "start": "2014-07-19",
            "end": "2014-11-16",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2015,
            "start": "2015-07-12",
            "end": "2015-11-14",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2016,
            "start": "2016-06-12",
            "end": "2016-10-02",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2017,
            "start": "2017-05-21",
            "end": "2017-09-10",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2018,
            "start": "2018-04-21",
            "end": "2018-08-04",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": false,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2019,
            "start": "2019-05-04",
            "end": "2019-08-18",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2020,
            "start": "2020-09-06",
            "end": "2021-02-06",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2021,
            "start": "2021-05-26",
            "end": "2021-11-13",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2022,
            "start": "2022-04-17",
            "end": "2022-09-25",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2023,
            "start": "2023-05-06",
            "end": "2023-09-23",
            "current": false,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          },
          {
            "year": 2024,
            "start": "2024-04-27",
            "end": "2024-09-29",
            "current": true,
            "coverage": {
              "fixtures": {
                "events": true,
                "lineups": true,
                "statistics_fixtures": false,
                "statistics_players": false
              },
              "standings": true,
              "players": true,
              "top_scorers": true,
              "top_assists": true,
              "top_cards": true,
              "injuries": false,
              "predictions": true,
              "odds": false
            }
          }
        ]
      }
      ],
      country: "",
      countries: [
		{
			"name": "Albania",
			"code": "AL",
			"flag": "https:\/\/media.api-sports.io\/flags\/al.svg"
		},
		{
			"name": "Algeria",
			"code": "DZ",
			"flag": "https:\/\/media.api-sports.io\/flags\/dz.svg"
		},
		{
			"name": "Andorra",
			"code": "AD",
			"flag": "https:\/\/media.api-sports.io\/flags\/ad.svg"
		},
		{
			"name": "Angola",
			"code": "AO",
			"flag": "https:\/\/media.api-sports.io\/flags\/ao.svg"
		},
		{
			"name": "Antigua-And-Barbuda",
			"code": "AG",
			"flag": "https:\/\/media.api-sports.io\/flags\/ag.svg"
		},
		{
			"name": "Argentina",
			"code": "AR",
			"flag": "https:\/\/media.api-sports.io\/flags\/ar.svg"
		},
		{
			"name": "Armenia",
			"code": "AM",
			"flag": "https:\/\/media.api-sports.io\/flags\/am.svg"
		},
		{
			"name": "Aruba",
			"code": "AW",
			"flag": "https:\/\/media.api-sports.io\/flags\/aw.svg"
		},
		{
			"name": "Australia",
			"code": "AU",
			"flag": "https:\/\/media.api-sports.io\/flags\/au.svg"
		},
		{
			"name": "Austria",
			"code": "AT",
			"flag": "https:\/\/media.api-sports.io\/flags\/at.svg"
		},
		{
			"name": "Azerbaijan",
			"code": "AZ",
			"flag": "https:\/\/media.api-sports.io\/flags\/az.svg"
		},
		{
			"name": "Bahrain",
			"code": "BH",
			"flag": "https:\/\/media.api-sports.io\/flags\/bh.svg"
		},
		{
			"name": "Bangladesh",
			"code": "BD",
			"flag": "https:\/\/media.api-sports.io\/flags\/bd.svg"
		},
		{
			"name": "Barbados",
			"code": "BB",
			"flag": "https:\/\/media.api-sports.io\/flags\/bb.svg"
		},
		{
			"name": "Belarus",
			"code": "BY",
			"flag": "https:\/\/media.api-sports.io\/flags\/by.svg"
		},
		{
			"name": "Belgium",
			"code": "BE",
			"flag": "https:\/\/media.api-sports.io\/flags\/be.svg"
		},
		{
			"name": "Belize",
			"code": "BZ",
			"flag": "https:\/\/media.api-sports.io\/flags\/bz.svg"
		},
		{
			"name": "Benin",
			"code": "BJ",
			"flag": "https:\/\/media.api-sports.io\/flags\/bj.svg"
		},
		{
			"name": "Bermuda",
			"code": "BM",
			"flag": "https:\/\/media.api-sports.io\/flags\/bm.svg"
		},
		{
			"name": "Bhutan",
			"code": "BT",
			"flag": "https:\/\/media.api-sports.io\/flags\/bt.svg"
		},
		{
			"name": "Bolivia",
			"code": "BO",
			"flag": "https:\/\/media.api-sports.io\/flags\/bo.svg"
		},
		{
			"name": "Bosnia",
			"code": "BA",
			"flag": "https:\/\/media.api-sports.io\/flags\/ba.svg"
		},
		{
			"name": "Botswana",
			"code": "BW",
			"flag": "https:\/\/media.api-sports.io\/flags\/bw.svg"
		},
		{
			"name": "Brazil",
			"code": "BR",
			"flag": "https:\/\/media.api-sports.io\/flags\/br.svg"
		},
		{
			"name": "Bulgaria",
			"code": "BG",
			"flag": "https:\/\/media.api-sports.io\/flags\/bg.svg"
		},
		{
			"name": "Burkina-Faso",
			"code": "BF",
			"flag": "https:\/\/media.api-sports.io\/flags\/bf.svg"
		},
		{
			"name": "Burundi",
			"code": "BI",
			"flag": "https:\/\/media.api-sports.io\/flags\/bi.svg"
		},
		{
			"name": "Cambodia",
			"code": "KH",
			"flag": "https:\/\/media.api-sports.io\/flags\/kh.svg"
		},
		{
			"name": "Cameroon",
			"code": "CM",
			"flag": "https:\/\/media.api-sports.io\/flags\/cm.svg"
		},
		{
			"name": "Canada",
			"code": "CA",
			"flag": "https:\/\/media.api-sports.io\/flags\/ca.svg"
		},
		{
			"name": "Chile",
			"code": "CL",
			"flag": "https:\/\/media.api-sports.io\/flags\/cl.svg"
		},
		{
			"name": "China",
			"code": "CN",
			"flag": "https:\/\/media.api-sports.io\/flags\/cn.svg"
		},
		{
			"name": "Chinese-Taipei",
			"code": "TW",
			"flag": "https:\/\/media.api-sports.io\/flags\/tw.svg"
		},
		{
			"name": "Colombia",
			"code": "CO",
			"flag": "https:\/\/media.api-sports.io\/flags\/co.svg"
		  }],
      visibleCount: 10,
      searchQuery: ''
    }
  },

  mounted() {
  },

  computed: {
    paginatedLeagues() {
      return this.filteredLeagues.slice(0, this.visibleCount);
    },
    filteredLeagues() {
      return this.leagues.filter(t => t.league.name.toLowerCase().includes(this.searchQuery.toLowerCase()));
    }
  },

  methods: {
    loadMore() {
      this.visibleCount += 10;
    }, 
    searchTeam() {
      this.visibleCount = 10;
    },
    async getLeaguesByCountry(){
      const response = await fetch(`http://127.0.0.1:8000/leagues/country/${this.country}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const data = await response.json()

      if (data.erro){
        alert(`Erro: ${data.erro}`)
      };

      this.leagues = data.data
    }
  },
}
</script>
    
    