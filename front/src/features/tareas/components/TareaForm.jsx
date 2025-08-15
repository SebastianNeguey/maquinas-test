// src/features/tareas/components/TareaForm.jsx
import React, { useState } from 'react';
import { crearTarea } from '../services';

function TareaForm({ idMaquina, onNuevaTarea }) {
  const [inicio, setInicio] = useState('');
  const [termino, setTermino] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (new Date(inicio) >= new Date(termino)) {
      setError('La fecha de inicio debe ser menor que la de término.');
      return;
    }

    try {
      const res = await crearTarea({
        id_maquina: idMaquina,
        fecha_inicio: inicio,
        fecha_termino: termino,
        estado: 'PENDIENTE',
      });
      console.log("Respuesta crearTarea:", res.data);
      onNuevaTarea(res.data);
      setInicio('');
      setTermino('');
      setError('');
    } catch (err) {
      setError('Error al crear la tarea.');
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-2">
      <div>
        <label>Inicio:</label>
        <input type="datetime-local" value={inicio} onChange={e => setInicio(e.target.value)} required className="input" />
      </div>
      <div>
        <label>Término:</label>
        <input type="datetime-local" value={termino} onChange={e => setTermino(e.target.value)} required className="input" />
      </div>
      {error && <p className="text-red-600">{error}</p>}
      <button type="submit" className="bg-blue-600 text-white px-3 py-1 rounded">Crear Tarea</button>
    </form>
  );
}

export default TareaForm;
