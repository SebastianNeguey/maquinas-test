import { useState, useEffect } from 'react';
import { getProduccionInactividad} from '../services';

export function useProduccionInactividad(idMaquina) {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (!idMaquina) return;
    getProduccionInactividad(idMaquina) // 🔍 filtro por máquina
    .then(res => setItems(res.data))
    .finally(() => setLoading(false));
  }, [idMaquina]);

  return { items, loading, setItems };
}
