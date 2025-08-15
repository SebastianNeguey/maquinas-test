// src/features/tareas/components/TareaList.jsx
import TareaForm from './TareaForm';
import TareaItem from './TareaItem';

function TareaList({ tareas, setTareas, idMaquina }) {
  const handleNueva = (nueva) => setTareas(prev => [...prev, nueva]);
  const handleDelete = (id) => setTareas(prev => prev.filter(t => t.id !== id));

  return (
    <div className="space-y-4 mt-4">
      <TareaForm idMaquina={idMaquina} onNuevaTarea={handleNueva} />
      {tareas.map(tarea => (
        <TareaItem
          key={tarea.id}
          tarea={tarea}
          onDelete={handleDelete}
        />
      ))}
    </div>
  );
}

export default TareaList;
