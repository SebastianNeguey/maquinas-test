import { useMaquinas } from './hooks/useMaquinas';
import MaquinaList from './components/MaquinaList';

function MaquinasManager({ onSeleccionar }) {
  const { maquinas, setMaquinas, loading } = useMaquinas();

  if (loading) return <p>Cargando máquinas...</p>;

  return (
    <MaquinaList
      maquinas={maquinas}
      setMaquinas={setMaquinas}
      onSeleccionar={onSeleccionar}
    />
  );
}

export default MaquinasManager;
