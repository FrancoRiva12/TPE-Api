TPE-Api
Esta API proporciona servicios para gestionar productos referidos a placas de video.

Listar todos los productos
Endpoint
GET /productos

Parámetros
orden (opcional): Campo por el cual ordenar los resultados (por defecto: ID).
direccion (opcional): Dirección de ordenamiento (ASC o DESC, por defecto: ASC).

Ejemplo

GET http://localhost/api/productos?orden=Precio&direccion=DESC
Obtener un producto por ID
Endpoint
GET /productos/{id}

Parámetros
id (requerido): ID del producto.
Ejemplo
GET http://localhost/api/productos/1
Agregar un nuevo producto
Endpoint
POST /productos

Datos requeridos en el cuerpo de la solicitud (JSON)

{
  "Marca": "Nvidia",
  "Modelo": "RTX 3080",
  "Descripcion": "Placa de video Gigabyte NVIDIA RTX 3080 de 12GB de Memoria",
  "Precio": 300
}

Ejemplo

POST "Content-Type: application/json" -d '{"Marca": "Nvidia", "Modelo": "RTX 3080", "Descripcion": "Placa de video Gigabyte NVIDIA RTX 3080 de 12GB de Memoria", "Precio": 300}' http://localhost/api/productos
Modificar un producto
Endpoint
PUT /productos/{id}

Datos requeridos en el cuerpo de la solicitud (JSON)
{
  "Marca": "AMD",
  "Modelo": "RX 6700XT",
  "Descripcion": "Placa de video Zotac 6700XT de 12GB de Memoria",
  "Precio": 250
}
Ejemplo
 PUT "Content-Type: application/json" '{"Marca": "AMD", "Modelo": "RX 6700XT", "Descripcion": "Placa de video Zotac 6700XT de 12GB de Memoria", "Precio": 250}' http://localhost/api/productos/2



