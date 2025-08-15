// src/features/maquinas/services.js
import axios from 'axios';

const apiLocal = import.meta.env.VITE_API_LOCAL;

export const getMaquinas = () => axios.get(`${apiLocal}/api/maquinas`);
export const crearMaquina = (data) => axios.post(`${apiLocal}/api/maquinas`, data);
export const actualizarMaquina = (id, data) => axios.put(`${apiLocal}/api/maquinas/${id}`, data);
export const eliminarMaquina = (id) => axios.delete(`${apiLocal}/api/maquinas/${id}`);
