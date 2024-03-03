__ENTORNO DE DESARROLLO__
  - Se utiliza docker.
  - El archivo docker-compose.yml especifica todo el detalle del entorno de desarrollo.
__DESCRIPCION DEL PROYECTO__
- La arquitectura fue separada en dos partes:
  - Backend: API desarrollada con PHP 8.1 (Laravel)
  - Frontend: Desarrollado con Javascript a través de Vue 3 y Tailwind CSS.
- Autenticación por TOKENS.
- Todo el versionado de cada elemento esta detallado en el archivo docker-compose y en las imágenes docker.
- Contempla Roles y Permisos para 3 tipos de usuarios, Administrador, Editor y Visitante.
  - Administrador tiene permisos completos. CRUD completo en clientes y ver, agregar y eliminar pagos.
    - admin@gmail.com : 123456789
  - Editor puede ver clientes, ver pagos y agregar pagos.
    - editor@gmail.com : 123456789
  - Visitante solo puede ver datos de clientes y pagos.
    - visitante@gmail.com : 123456789

__BASE DE DATOS__
-  Se utilizó MySQL y el nombre de la Base de Datos es "anderson".
-  Se adjunta script de la Base de Datos con información de prueba.
-  Las tablas son:
  - __users:__ Contiene los usuarios del sistema.
  - __clientes:__ Contiene datos de clientes. (CRUD completo).
  - __pagos:__ Contiene los pagos de los clientes. (Ver, Agregar y Borrar).
  - cliente->pagos: Relación uno a muchos.
  - __roles:__ Contiene los roles de los usuarios.
  - __permissions:__ Contine los permisos del sistema.
  - __role_has_permissions:__ Contiene los permisos según cada rol.
  - Otras tablas auxiliares y complementarias para roles y permisos.
__FUNCIONALIDADES__
- Login
- Logout
- Registro de Usuarios
- Ver, Agregar, Modificar y Borrar Clientes.
- Ver, Agregar y Borrar pagos de los Clientes.
- Manejo de datos reactivos y responsivos con DataTables.
