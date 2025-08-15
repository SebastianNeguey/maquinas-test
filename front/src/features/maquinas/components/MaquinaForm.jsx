import { useState } from 'react';
import { crearMaquina, actualizarMaquina } from '../services';

function MaquinaForm({ onSave, maquinaEditando, onCancel }) {
  const [nombre, setNombre] = useState(maquinaEditando?.nombre || '');
  const [coef, setCoef] = useState(maquinaEditando?.coeficiente || '');

  const handleSubmit = async (e) => {
    e.preventDefault();
    const data = { nombre, coeficiente: parseFloat(coef) };

    const res = maquinaEditando
      ? await actualizarMaquina(maquinaEditando.id, data)
      : await crearMaquina(data);

    onSave(res.data);
    setNombre('');
    setCoef('');
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-2 border p-4 rounded">
      <input
        value={nombre}
        onChange={e => setNombre(e.target.value)}
        placeholder="Nombre"
        required
        className="input w-full"
      />
      <input
        type="number"
        value={coef}
        onChange={e => setCoef(e.target.value)}
        placeholder="Coeficiente (ej: 1.25)"
        step="0.01"
        required
        className="input w-full"
      />
      <div className="flex gap-2">
        <button type="submit" className="bg-blue-600 text-white px-4 py-1 rounded">
          {maquinaEditando ? 'Actualizar' : 'Crear'}
        </button>
        {maquinaEditando && (
          <button onClick={onCancel} type="button" className="text-gray-500">Cancelar</button>
        )}
      </div>
    </form>
  );
}

export default MaquinaForm;
