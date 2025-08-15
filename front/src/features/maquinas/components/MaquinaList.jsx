import MaquinaItem from './MaquinaItem';
import MaquinaForm from './MaquinaForm';
import { eliminarMaquina } from '../services';
import { useState } from 'react';

function MaquinaList({ maquinas, setMaquinas, onSeleccionar }) {
  const [editando, setEditando] = useState(null);

  const handleGuardar = (maquina) => {
    if (editando) {
      setMaquinas(prev => prev.map(m => m.id === maquina.id ? maquina : m));
    } else {
      setMaquinas(prev => [...prev, maquina]);
    }
    setEditando(null);
  };

  const handleEliminar = async (id) => {
    if (confirm('¿Eliminar esta máquina?')) {
      await eliminarMaquina(id);
      setMaquinas(prev => prev.filter(m => m.id !== id));
    }
  };

  return (
    <div className="space-y-4">
      <h2 className="text-xl font-semibold">Maquinas</h2>
      <MaquinaForm onSave={handleGuardar} maquinaEditando={editando} onCancel={() => setEditando(null)} />
      {maquinas.map(maquina => (
        <MaquinaItem
          key={maquina.id}
          maquina={maquina}
          onSelect={onSeleccionar}
          onEdit={setEditando}
          onDelete={handleEliminar}
        />
      ))}
    </div>
  );
}

export default MaquinaList;
