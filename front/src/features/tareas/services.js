// src/features/tareas/services.js
import axios from 'axios';

const apiLocal = import.meta.env.VITE_API_LOCAL;

export const getTareasByMaquina = (idMaquina) =>
  axios.get(`${apiLocal}/api/tareas/${idMaquina}`);

export const crearTarea = (datos) =>
  axios.post(`${apiLocal}/api/tareas`, datos);

export const eliminarTarea = (id) =>
  axios.delete(`${apiLocal}/api/tareas/${id}`);