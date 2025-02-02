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
            <input class="form-control" type="search" placeholder="Busque por um campeonato" aria-label="Busque por um time" v-model="searchQuery" @input="searchTeam" :disabled="!country">
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
import { apiService } from '@/services/apiService';

export default {
  components: {
    NavBar
  },

  data() {
    return {
      leagues: [],
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
      searchQuery: '',
      apiService: apiService
    }
  },

  async mounted() {
    this.countries = await this.apiService.getCountries();
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

      this.leagues = data.data.response
    }
  },
}
</script>
    
    