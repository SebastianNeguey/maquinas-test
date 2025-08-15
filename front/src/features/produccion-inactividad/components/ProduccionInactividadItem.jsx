export default function ProduccionInactividadItem({ item}) {
  return (
    <div className="flex justify-between items-center p-2 border-b">
      <div>
        <p><strong>Tiempo:</strong> {item.tiempo_produccion}</p>
        <p><strong>Inactividad</strong>{item.tiempo_inactividad}</p>
        <p><strong>Fecha inicio:</strong> {item.fecha_hora_inicio_inactividad}</p>
        <p><strong>Fecha fin:</strong> {item.fecha_hora_termino_inactividad}</p>
      </div>
    </div>
  );
}
