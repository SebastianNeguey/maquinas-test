// src/features/tareas/hooks/useTareas.js
import { useState, useEffect } from 'react';
import { getTareasByMaquina } from '../services';

export function useTareas(idMaquina) {
  const [tareas, setTareas] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!idMaquina) return;

    setLoading(true);
    getTareasByMaquina(idMaquina)
      .then(res => setTareas(res.data))
      .finally(() => setLoading(false));
  }, [idMaquina]);

  return { tareas, setTareas, loading };
}
