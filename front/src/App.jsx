import { useState } from 'react';
import MaquinasManager from './features/maquinas';
import TareasManager from './features/tareas';
import ProduccionInactividadManager from './features/produccion-inactividad';

function App() {
  const [maquinaSeleccionada, setMaquinaSeleccionada] = useState(null);

  return (
    <div className="p-4 max-w-6xl mx-auto">
      <div className="flex gap-8">
        <div className="w-1/3">{/* Columna izquierda: Maquinas */}
          <MaquinasManager onSeleccionar={setMaquinaSeleccionada} />
        </div>
         <div className="w-2/3"> {/* Columna derecha: Tareas + Producción */}
          {maquinaSeleccionada ? (
            <>
              <hr />
              <h2 className="text-2xl font-bold">Tareas, produccion e Inactividad de {maquinaSeleccionada.nombre}</h2>
              <TareasManager idMaquina={maquinaSeleccionada.id} />
              <ProduccionInactividadManager idMaquina={maquinaSeleccionada.id} />
            </>
          ): (
              <p className="text-gray-500">Selecciona una máquina para ver detalles</p>
          )}
        </div>
      </div>
    </div>
  );
}

export default App;
