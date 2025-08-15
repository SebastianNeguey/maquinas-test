// src/features/tareas/index.jsx
import { useTareas } from './hooks/useTareas';
import TareaList from './components/TareaList';

function TareasManager({ idMaquina }) {
  const { tareas, setTareas, loading } = useTareas(idMaquina);

  if (!idMaquina) return <p>Seleccione una máquina.</p>;
  if (loading) return <p>Cargando tareas...</p>;

  return (
    <div>
      <h2 className="text-xl font-semibold mb-4">Tareas</h2>
      <TareaList tareas={tareas} setTareas={setTareas} idMaquina={idMaquina} />
    </div>
  );
}

export default TareasManager;
