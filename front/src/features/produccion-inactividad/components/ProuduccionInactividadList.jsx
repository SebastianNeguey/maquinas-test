import ProduccionInactividadItem from './ProduccionInactividadItem';

function ProduccionInactividadList({ items}) {
  return (
    <div>
      <h2 className="text-lg font-bold mb-4">Producción e Inactividad</h2>
      {Array.isArray(items) && items.map(item => (
        <ProduccionInactividadItem
          key={item.id}
          item={item}
        />
      ))}
    </div>
  );
}
export default ProduccionInactividadList;
