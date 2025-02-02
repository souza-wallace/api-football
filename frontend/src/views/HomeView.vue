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
            <select class="form-select" v-model="params.country" @change="getLeagues">
              <option value="" disabled selected>Selecione o país</option>
              <option :value="c.name" v-for="(c, index) in countries" :key="index">{{ c.name }}</option>
            </select>
          </div>

          <!-- Selecionar Liga -->
          <div class="col-md-3">
            <label class="form-label">Liga</label>
            <select class="form-select" v-model="params.leagueId" :disabled="!params.country">
              <option value="" disabled selected>Selecione a liga</option>
              <option :value="l.league.id" v-for="(l, index) in leagues" :key="index">{{ l.league.name }}</option>
            </select>
          </div>

          <!-- Selecionar Ano -->
          <div class="col-md-2">
            <label class="form-label">Ano</label>
            <select class="form-select" v-model="params.year" :disabled="!params.leagueId">
              <option value="" disabled selected>Selecione o ano</option>
              <option :value="y" v-for="(y, index) in years" :key="index">{{ y }}</option>
            </select>
          </div>

          <!-- Selecionar Rodada -->
          <div class="col-md-2">
            <label class="form-label">Rodada</label>
            <select class="form-select" v-model="params.round" :disabled="!params.year">
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
              <img :src="league.logo" class="card-img-top mb-2" alt="league Emblem" style="height: 100px; width: auto; object-fit: contain;">
            </div>
            <div class="row justify-content-center mb-4">
              {{league.name}}
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
                <td>{{ c.rank }}</td>
                <td class="team-cell">
                  <img :src="c.team.logo" :alt="c.team.name" class="team-logo"> 
                  <span class="team-name">{{ c.team.name }}</span>
                </td>
                <td>{{ c.points }}</td>
                <td>{{ c.all.goals.for }}</td>
                <td>{{ c.all.goals.against }}</td>
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
                    <p><strong>Data:</strong> {{ this.apiService.formatTime(j.fixture.date) }}</p>
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
      leagues: {},
      league: [],
      countries: [],
      jogos:[],
      classificacao: [],
      years: ['2019', '2020', '2021', '2022', '2023', '2024', '2025'],
	  params:{
		round: '',
		country: '',
		leagueId: '',
		year: '',
	  },
	  apiService: apiService
    }
  },

  async mounted() {
    this.countries = await this.apiService.getCountries();
  },

  methods: {
    async getLeagues() {
      if (!this.params.country) return;

      try {
        const response = await fetch(`http://127.0.0.1:8000/leagues/country/${this.params.country}`);
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
      if (!this.params.leagueId && !this.params.year && !this.params.round){
        alert('Preencha todos os campos')
        throw new Error(`Erro: Preencha todos os campos`);
      }

      try {
        const response = await fetch(`http://127.0.0.1:8000/leagues/${this.params.leagueId}/season/${this.params.year}/round/${this.params.round}`);
        const data = await response.json()

        if (data.erro){
          alert(`Erro: ${data.erro}`)
        };

        this.jogos = data.data?.jogos.response;
        this.league = data.data?.classificacao.response[0].league;
        this.classificacao = this.league.standings[0];

		console.log(this.league, this.classificacao, 'cla')

      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
<style scoped>
.team-cell {
  display: flex;
  align-items: center;  /* Alinha verticalmente */
  gap: 10px;  /* Espaço entre a imagem e o texto */
  justify-content: start; /* Alinha à esquerda */
}

.team-logo {
  height: 40px;
  width: auto; /* Mantém a proporção */
}

.team-name {
  font-size: 16px;
  font-weight: bold;
}

</style>