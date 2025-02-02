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
      teamData: {},
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
      const response = await fetch(`http://127.0.0.1:8000/teams/${this.id}/statistics/season/${this.year}/league/${this.leagueId}`, {
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
    
    