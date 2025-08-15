import { useProduccionInactividad } from './hooks/useProudccionInactividad';
import ProduccionInactividadList from './components/ProuduccionInactividadList';

function ProudccionInactividadManager({ idMaquina }) {
  const { items, setItems, loading } = useProduccionInactividad(idMaquina);

  if (!idMaquina) return <p>Seleccione una máquina.</p>;
  if (loading) return <p>Cargando Produccion e Inactividad...</p>;

  return (
    <div>
      <h2 className="text-xl font-semibold mb-4">Producciones e Inactividades</h2>
      <ProduccionInactividadList items={items}/>
    </div>
  );
}

export default ProudccionInactividadManager;