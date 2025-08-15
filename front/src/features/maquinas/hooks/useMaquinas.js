// src/features/maquinas/hooks/useMaquinas.js
import { useEffect, useState } from 'react';
import { getMaquinas } from '../services';

export function useMaquinas() {
  const [maquinas, setMaquinas] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getMaquinas()
      .then(res => setMaquinas(res.data))
      .finally(() => setLoading(false));
  }, []);

  return { maquinas, setMaquinas, loading };
}
