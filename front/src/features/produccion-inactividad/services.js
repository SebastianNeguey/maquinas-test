import axios from 'axios';

const apiLocal = import.meta.env.VITE_API_LOCAL;

export const getProduccionInactividad = (machineId) => 
  axios.get(`${apiLocal}/api/producciones/${machineId}`);