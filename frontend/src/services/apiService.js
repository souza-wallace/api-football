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

    formatTime(value) {
      if(!value) return '-'
      
      const date = new Date(value);
      return new Intl.DateTimeFormat('pt-BR', {
          day: '2-digit',
          month: '2-digit',
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          hour12: false
      }).format(date);
    }
  };