<template>
<div>
    <NavBar />

    <!-- Filtros -->
    <div class="container mt-4">
      <div class="card p-4 shadow-sm">
        <div class="row g-3 align-items-end">
          <!-- Selecionar País -->
          <div class="col-md-3">
            <label class="form-label">País</label>
            <select class="form-select" v-model="country" @change="getLeagues">
              <option value="" disabled selected>Selecione o país</option>
              <option :value="c.name" v-for="(c, index) in countries" :key="index">{{ c.name }}</option>
            </select>
          </div>

          <!-- Selecionar Liga -->
          <div class="col-md-3">
            <label class="form-label">Liga</label>
            <select class="form-select" v-model="leagueId" :disabled="!country">
              <option value="" disabled selected>Selecione a liga</option>
              <option :value="l.league.id" v-for="(l, index) in leagues" :key="index">{{ l.league.name }}</option>
            </select>
          </div>

          <!-- Selecionar Ano -->
          <div class="col-md-2">
            <label class="form-label">Ano</label>
            <select class="form-select" v-model="year" :disabled="!leagueId">
              <option value="" disabled selected>Selecione o ano</option>
              <option :value="y" v-for="(y, index) in years" :key="index">{{ y }}</option>
            </select>
          </div>

          <!-- Selecionar Rodada -->
          <div class="col-md-2">
            <label class="form-label">Rodada</label>
            <select class="form-select" v-model="round" :disabled="!year">
              <option value="" disabled selected>Selecione a rodada</option>
              <option :value="index+1" v-for="(r, index) in 38" :key="index">Rodada {{ index+1 }}</option>
            </select>
          </div>

          <!-- Botão Pesquisar -->
          <div class="col-md-2 text-end">
            <button class="btn btn-primary w-100" @click="getLeaguesInfo">Pesquisar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Conteúdo Principal -->
    <div class="container mt-5">
      <div class="row g-4">
        <!-- Classificação -->
        <div class="col-lg-8" v-if="classificacao.length != 0">
          <div class="card p-4 shadow-sm">
            <div class="row justify-content-center">
              <img :src="leagues[0].league.logo" class="card-img-top mb-2" alt="league Emblem" style="height: 100px; width: auto; object-fit: contain;">
            </div>
            <div class="row justify-content-center mb-4">
              {{leagues[0].league.name}}
            </div>

            <table class="table table-hover text-center">
              <thead class="table-light">
                <tr>
                  <th>Posição</th>
                  <th>Time</th>
                  <th>Pontos</th>
                  <th>Gols Feitos</th>
                  <th>Gols Sofridos</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(c, index) in classificacao" :key="index">
                  <td>{{ c.league.standings[0][0].rank }}</td>
                  <td>
                    <img :src="c.league.standings[0][0].team.logo" :alt="c.league.standings[0][0].team.name" class="" style="height: 40px;"> 
                    {{ c.league.standings[0][0].team.name }}
                  </td>
                  <td>{{ c.league.standings[0][0].points }}</td>
                  <td>{{ c.league.standings[0][0].all.goals.for }}</td>
                  <td>{{ c.league.standings[0][0].all.goals.against }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Últimos Jogos -->
        <div class="col-lg-4" v-if="jogos.length != 0">
          <div class="card p-4 shadow-sm">
            <h5 class="mb-4">Últimos Jogos</h5>
            <div class="accordion" id="gamesAccordion">
              <div class="accordion-item" v-for="(j, index) in jogos" :key="index">
                <h2 class="accordion-header" :id="'game-header-' + index">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                    :data-bs-target="'#game-collapse-' + index" 
                    aria-expanded="false" 
                    :aria-controls="'game-collapse-' + index">
                    {{ j.teams.home.name }} x {{ j.teams.away.name }}
                  </button>
                </h2>
                <div :id="'game-collapse-' + index" class="accordion-collapse collapse" 
                  :aria-labelledby="'game-header-' + index" data-bs-parent="#gamesAccordion">
                  <div class="accordion-body">
                    <p><strong>Data:</strong> {{ j.fixture.date }}</p>
                    <p><strong>Estádio:</strong> {{ j.fixture.venue.name }} - {{ j.fixture.venue.city }}</p>
                    <p><strong>Árbitro:</strong> {{ j.fixture.referee }}</p>
                    <p><strong>Resultado:</strong> {{ j.goals.home }} x {{ j.goals.away }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from '../components/NavBar.vue';
import { apiService } from '@/services/apiService';

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
		  }
      ],
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
      jogos:[],
      classificacao: [],
      teams: [],
      data: [],
      years: ['2019', '2020', '2021', '2022', '2023', '2024', '2025'],
      round: '',
      country: '',
      leagueId: '',
      year: ''
    }
  },

  async mounted() {
    this.countries = await apiService.getCountries();
  },

  methods: {
    async getLeagues() {
      this.country = 'Brazil'
      if (!this.country) return;
      try {
        const response = await fetch(`http://127.0.0.1:8000/leagues/country/${this.country}`);
        const data = await response.json()

        if (data.erro){
          alert(`Erro: ${data.erro}`)
        };

        this.leagues = data.data.response;
      } catch (error) {
        console.error(error);
      }
    },

    async getLeaguesInfo() {
      if (!this.leagueId && !this.year && !this.round){
        alert('Preencha todos os campos')
        throw new Error(`Erro: Preencha todos os campos`);
      }

      try {
        const response = await fetch(`http://127.0.0.1:8000/leagues/${this.leagueId}/season/${this.year}/round/${this.round}`);
        const data = await response.json()

        if (data.erro){
          alert(`Erro: ${data.erro}`)
        };

        this.jogos = data.data?.response.jogos;
        this.classificacao = data.data?.response.classificacao;

      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
