// src/features/tareas/components/TareaItem.jsx
import {eliminarTarea } from '../services';

function TareaItem({ tarea, onDelete}) {

  const handleEliminar = async () => {
    if (confirm('¿Eliminar esta tarea?')) {
      await eliminarTarea(tarea.id);
      onDelete(tarea.id);
    }
  };

  return (
    <div className="border p-3 rounded shadow flex justify-between items-center">
      <div>
        <p><strong>Inicio:</strong> {tarea.fecha_inicio}</p>
        <p><strong>Término:</strong> {tarea.fecha_termino}</p>
        <p><strong>Estado:</strong> {tarea.estado}</p>
      </div>
      <div className="flex gap-2">
        <button onClick={handleEliminar} className="text-red-600 hover:underline">Eliminar</button>
      </div>
    </div>
  );
}

export default TareaItem;
