export const apiService = {
    async getCountries() {
      try {
        const response = await fetch('http://127.0.0.1:8000/countries');
        const data = await response.json();

        if (data.erro){
          alert(`Erro: ${data.erro}`)
        };
        
        return data.data.response;
      } catch (error) {
        console.error(error);
        throw error;
      }
    },
  };