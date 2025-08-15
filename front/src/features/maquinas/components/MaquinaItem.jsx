function MaquinaItem({ maquina, onSelect, onDelete, onEdit }) {
  return (
    <div className="border p-3 rounded flex justify-between items-center">
      <div>
        <p><strong>{maquina.nombre}</strong></p>
        <p>Coeficiente: {maquina.coeficiente}</p>
      </div>
      <div className="flex gap-2">
        <button onClick={() => onSelect(maquina)} className="text-blue-600 hover:underline">Ver tareas</button>
        <button onClick={() => onEdit(maquina)} className="text-yellow-600 hover:underline">Editar</button>
        <button onClick={() => onDelete(maquina.id)} className="text-red-600 hover:underline">Eliminar</button>
      </div>
    </div>
  );
}

export default MaquinaItem;
