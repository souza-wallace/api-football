<template>
  <div>
    <NavBar />
    <div class="container mt-4">
      <div class="card p-4 shadow-sm">
        <div class="row g-3 align-items-end justify-content-end">
          <!-- Selecionar Liga -->
          <div class="col-md-2">
            <label class="form-label">Liga</label>
            <select class="form-select" v-model="leagueId">
              <option value="" disabled selected>Selecione a liga</option>
              <option :value="l.league.id" v-for="(l, index) in leagues" :key="index">{{ l.league.name }}</option>
            </select>
          </div>

          <!-- Selecionar Ano -->
          <div class="col-md-2">
            <label class="form-label">Ano</label>
            <select class="form-select" v-model="year">
              <option value="" disabled selected>Selecione o ano</option>
              <option :value="y" v-for="(y, index) in years" :key="index">{{ y }}</option>
            </select>
          </div>

          <!-- Botão Pesquisar -->
          <div class="col-md-2 text-end">
            <button class="btn btn-primary w-100" @click="getInfoTeam">Pesquisar</button>
          </div>
        </div>
      </div>

      <!-- Informações do Time -->
      <div class="text-center mt-5">
        <h5>{{ team?.name || 'Time'}}</h5>
        <img v-if="team?.logo" class="team-logo" :src="team?.logo" alt="Time">
      </div>

      <!-- Estatísticas -->
      <div class="row mt-5">
        <div class="col-md-6">
          <div class="card p-2 shadow-sm text-center">
            <h6 class="mb-1">Competição</h6>
            <div>
              <img v-if="teamData?.league?.logo" class="league-logo mb-1" :src="teamData?.league?.logo" alt="Liga">
            </div>
            <div>
              <p class="small mb-0">{{ teamData.league?.name || 'Nenhuma' }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card p-2 shadow-sm text-center">
            <h6>Partidas</h6>
            <ul class="list-unstyled small mb-0">
              <li><strong>Jogos:</strong> {{ teamData.fixtures?.played.total || 0 }}</li>
              <li><strong>Vitórias:</strong> {{ teamData.fixtures?.wins.total || 0 }}</li>
              <li><strong>Empates:</strong> {{ teamData.fixtures?.draws.total || 0 }}</li>
              <li><strong>Derrotas:</strong> {{ teamData.fixtures?.loses.total || 0 }}</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Gols -->
      <div class="row mt-3">
        <div class="col-md-6">
          <div class="card p-2 shadow-sm text-center">
            <h6>Gols a Favor</h6>
            <p class="small"><strong>Total:</strong> {{ teamData.goals?.for.total.total || 0 }}</p>
            <p class="small"><strong>Média:</strong> {{ teamData.goals?.for.average.total || 0 }}</p>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card p-2 shadow-sm text-center">
            <h6>Gols Sofridos</h6>
            <p class="small"><strong>Total:</strong> {{ teamData.goals?.against.total.total || 0 }}</p>
            <p class="small"><strong>Média:</strong> {{ teamData.goals?.against.average.total || 0 }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.team-logo {
  max-width: 100px;
  margin-top: 5px;
}

.league-logo {
  max-width: 80px;
}

.card {
  border-radius: 8px;
}
</style>


    
<script>
import NavBar from '../components/NavBar.vue';

export default {
  components: {
    NavBar
  },

  data() {
    return {
      team:{},
      teamData: {
"league": {
"id": 39,
"name": "Premier League",
"country": "England",
"logo": "https://media.api-sports.io/football/leagues/39.png",
"flag": "https://media.api-sports.io/flags/gb-eng.svg",
"season": 2019
},
"team": {
"id": 33,
"name": "Manchester United",
"logo": "https://media.api-sports.io/football/teams/33.png"
},
"form": "WDLDWLDLDWLWDDWWDLWWLWLLDWWDWDWWWWDWDW",
"fixtures": {
"played": {
"home": 19,
"away": 19,
"total": 38
},
"wins": {
"home": 10,
"away": 8,
"total": 18
},
"draws": {
"home": 7,
"away": 5,
"total": 12
},
"loses": {
"home": 2,
"away": 6,
"total": 8
}
},
"goals": {
"for": {
"total": {
"home": 40,
"away": 26,
"total": 66
},
"average": {
"home": "2.1",
"away": "1.4",
"total": "1.7"
},
"minute": {
"0-15": {
"total": 4,
"percentage": "6.06%"
},
"16-30": {
"total": 17,
"percentage": "25.76%"
},
"31-45": {
"total": 11,
"percentage": "16.67%"
},
"46-60": {
"total": 13,
"percentage": "19.70%"
},
"61-75": {
"total": 10,
"percentage": "15.15%"
},
"76-90": {
"total": 8,
"percentage": "12.12%"
},
"91-105": {
"total": 3,
"percentage": "4.55%"
},
"106-120": {
"total": null,
"percentage": null
}
},
"under_over": {
"0.5": {
"over": 30,
"under": 8
},
"1.5": {
"over": 20,
"under": 18
},
"2.5": {
"over": 11,
"under": 27
},
"3.5": {
"over": 4,
"under": 34
},
"4.5": {
"over": 1,
"under": 37
}
}
},
"against": {
"total": {
"home": 17,
"away": 19,
"total": 36
},
"average": {
"home": "0.9",
"away": "1.0",
"total": "0.9"
},
"minute": {
"0-15": {
"total": 6,
"percentage": "16.67%"
},
"16-30": {
"total": 3,
"percentage": "8.33%"
},
"31-45": {
"total": 7,
"percentage": "19.44%"
},
"46-60": {
"total": 9,
"percentage": "25.00%"
},
"61-75": {
"total": 3,
"percentage": "8.33%"
},
"76-90": {
"total": 5,
"percentage": "13.89%"
},
"91-105": {
"total": 3,
"percentage": "8.33%"
},
"106-120": {
"total": null,
"percentage": null
}
},
"under_over": {
"0.5": {
"over": 25,
"under": 13
},
"1.5": {
"over": 10,
"under": 28
},
"2.5": {
"over": 1,
"under": 37
},
"3.5": {
"over": 0,
"under": 38
},
"4.5": {
"over": 0,
"under": 38
}
}
}
},
"biggest": {
"streak": {
"wins": 4,
"draws": 2,
"loses": 2
},
"wins": {
"home": "4-0",
"away": "0-3"
},
"loses": {
"home": "0-2",
"away": "2-0"
},
"goals": {
"for": {
"home": 5,
"away": 3
},
"against": {
"home": 2,
"away": 3
}
}
},
"clean_sheet": {
"home": 7,
"away": 6,
"total": 13
},
"failed_to_score": {
"home": 2,
"away": 6,
"total": 8
},
"penalty": {
"scored": {
"total": 10,
"percentage": "100.00%"
},
"missed": {
"total": 0,
"percentage": "0%"
},
"total": 10
},
"lineups": [
{
"formation": "4-2-3-1",
"played": 32
},
{
"formation": "3-4-1-2",
"played": 4
},
{
"formation": "3-4-2-1",
"played": 1
},
{
"formation": "4-3-1-2",
"played": 1
}
],
"cards": {
"yellow": {
"0-15": {
"total": 5,
"percentage": "6.85%"
},
"16-30": {
"total": 5,
"percentage": "6.85%"
},
"31-45": {
"total": 16,
"percentage": "21.92%"
},
"46-60": {
"total": 12,
"percentage": "16.44%"
},
"61-75": {
"total": 14,
"percentage": "19.18%"
},
"76-90": {
"total": 21,
"percentage": "28.77%"
},
"91-105": {
"total": null,
"percentage": null
},
"106-120": {
"total": null,
"percentage": null
}
},
"red": {
"0-15": {
"total": null,
"percentage": null
},
"16-30": {
"total": null,
"percentage": null
},
"31-45": {
"total": null,
"percentage": null
},
"46-60": {
"total": null,
"percentage": null
},
"61-75": {
"total": null,
"percentage": null
},
"76-90": {
"total": null,
"percentage": null
},
"91-105": {
"total": null,
"percentage": null
},
"106-120": {
"total": null,
"percentage": null
}
}
}

      },
      id: this.$route.params.id,
      country: '',
      leagues: [],
      leagueId: '',
      years: ['2019', '2020', '2021', '2022', '2023', '2024', '2025'],
      year: ''
    }
  },

  mounted() {
    this.getTeam();
  },

  methods: {
    async getTeam(){
      console.log(this.id)
      const response = await fetch(`http://127.0.0.1:8000/teams/${this.id}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const data =  await response.json();
      if (data.erro){
        alert(`Erro: ${data.erro}`)
      };
      this.team = data.data.response[0].team
      this.getLeaguesByTeam(this.team.id);
    },

    async getInfoTeam(){
      const response = await fetch(`http://127.0.0.1:8000//teams/${this.id}/statistics/season/${this.year}/league/${this.leagueId}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const data =  await response.json();

      if (data.erro){
        alert(`Erro: ${data.erro}`)
      };

      this.teamData = data.data
    },

    async getLeaguesByTeam(id){
      console.log(id,'id team')
      if(!id) return

      const response = await fetch('http://127.0.0.1:8000/leagues/team/'+id, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json'
        }
      });

      const data =  await response.json();
      if (data.erro){
        alert(`Erro: ${data.erro}`)
      };

      this.leagues = data.data.response
    },
  },
}
</script>
    
    