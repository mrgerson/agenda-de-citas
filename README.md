# Sistema de Gestión Médica - Prueba Técnica

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Descripción del Proyecto

Sistema de gestión médica desarrollado como prueba técnica que incluye tres módulos principales:

- **📋 Módulo de Pacientes**: CRUD completo con validaciones
- **📅 Módulo de Agendamiento**: Gestión de citas médicas
- **🏥 Módulo de Admisiones**: Control de asistencia y admisión de pacientes

## Características Técnicas

- **Framework**: Laravel 12
- **PHP**: 8.2 o superior
- **Base de Datos**: SQL SERVER
- **Frontend**: Blade Templates + Tailwind CSS
- **Arquitectura**: Repository Pattern + Service Layer
- **Autenticación**: Laravel Auth
- **Interfaz**: Responsive y moderna

## Funcionalidades Implementadas

### 🩺 Módulo de Pacientes
- ✅ CRUD completo (Crear, Leer, Actualizar, Eliminar)
- ✅ Validaciones robustas (documentos únicos, edades, etc.)
- ✅ Búsqueda y filtrado
- ✅ Paginación

### 📅 Módulo de Citas
- ✅ Agendamiento de citas
- ✅ Gestión de estados (Programada, Confirmada, Cancelada, Completada)
- ✅ Validación de horarios únicos
- ✅ Integración con pacientes

### 🏥 Módulo de Admisiones
- ✅ Registro de admisiones desde citas confirmadas
- ✅ Control de asistencia
- ✅ Estados: Pendiente, Admitido, No Asistió
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Notas de admisión

## Requisitos del Sistema

- **PHP**: 8.2 o superior
- **Composer**: 2.0 o superior
- **Node.js**: 18 o superior (para assets)
- **SQL Server**: 2019 o superior
- **Extensión PHP**: `pdo_sqlsrv` y `sqlsrv`

## Instalación y Configuración

### 1. Clonar el Repositorio

```bash
cd tu-directorio-preferido
git clone [URL-DEL-REPOSITORIO]
cd prueba-tecnica
```

### 2. Instalar Dependencias de PHP

Si es la primera vez que descargas el proyecto, ejecuta:

```bash
composer install
```

### 3. Configurar el Entorno

Copia el archivo de configuración y genera la clave de aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar Base de Datos

El proyecto usa **SQL Server** por defecto. 

**Requisitos previos:**
- Tener SQL Server instalado y ejecutándose
- Crear una base de datos para el proyecto

**Configuración en `.env`:**
```env
DB_CONNECTION=sqlsrv
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=tu_nombre_base_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

**Para Laragon/XAMPP con SQL Server:**
```env
DB_CONNECTION=sqlsrv
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=prueba_tecnica
DB_USERNAME=sa
DB_PASSWORD=tu_contraseña_sa
```

> **Nota importante**: Asegúrate de tener instaladas las extensiones de SQL Server para PHP:
> - Descarga los drivers desde: [Microsoft SQL Server PHP Drivers](https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server)
> - En Laragon, las extensiones deben estar habilitadas en `php.ini`:
>   ```ini
>   extension=pdo_sqlsrv
>   extension=sqlsrv
>   ```

### 5. Ejecutar Migraciones y Seeders

Ejecuta las migraciones y carga datos de prueba:

```bash
php artisan migrate --seed
```

Este comando creará las tablas y cargará datos de ejemplo incluyendo:
- Usuario de prueba (admin@test.com / password)
- 10 pacientes de ejemplo
- 15 citas de ejemplo
- 5 admisiones de ejemplo

### 6. Instalar Dependencias de Frontend (Opcional)

Si necesitas recompilar los assets:

```bash
npm install
npm run build
```

### 7. Ejecutar el Servidor de Desarrollo

```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

## Credenciales de Acceso

**Usuario de prueba:**
- **Email**: admin@test.com
- **Contraseña**: password

## Estructura del Proyecto

```
app/
├── Http/
│   ├── Controllers/          # Controladores
│   ├── Requests/            # Validaciones de formularios
│   └── Middleware/          # Middleware personalizado
├── Models/                  # Modelos Eloquent
├── Repositories/            # Patrón Repository
│   ├── Contracts/          # Interfaces
│   └── Eloquent/           # Implementaciones
├── Services/               # Capa de servicios
└── Providers/              # Service Providers

database/
├── migrations/             # Migraciones de base de datos
└── seeders/               # Seeders para datos de prueba

resources/
├── views/                 # Plantillas Blade
│   ├── auth/             # Autenticación
│   ├── pacientes/        # Módulo de pacientes
│   ├── citas/           # Módulo de citas
│   ├── admisiones/      # Módulo de admisiones
│   └── layouts/         # Layouts principales
└── css/                  # Estilos CSS
```

## Comandos Útiles

### Limpiar Cachés
```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Ver Rutas
```bash
php artisan route:list
```

### Ejecutar Tests (si están implementados)
```bash
php artisan test
```

### Regenerar Datos de Prueba
```bash
php artisan migrate:fresh --seed
```

## Funcionalidades por Módulo

### 👤 Pacientes
- `/pacientes` - Lista de pacientes
- `/pacientes/create` - Crear nuevo paciente
- `/pacientes/{id}` - Ver detalles del paciente
- `/pacientes/{id}/edit` - Editar paciente

### 📅 Citas
- `/citas` - Lista de citas
- `/citas/create` - Agendar nueva cita
- `/citas/{id}` - Ver detalles de la cita
- `/citas/{id}/edit` - Editar cita
- Acciones: Confirmar, Cancelar, Completar

### 🏥 Admisiones
- `/admisiones-dashboard` - Dashboard principal
- `/admisiones` - Lista de admisiones
- `/admisiones/create` - Crear nueva admisión
- `/admisiones/{id}` - Ver detalles de la admisión
- `/admisiones/{id}/edit` - Editar admisión
- Acciones: Marcar como admitido, Marcar como no asistió

## Tecnologías Utilizadas

- **Backend**: Laravel 12, PHP 8.2
- **Frontend**: Blade, Tailwind CSS, Font Awesome
- **Base de Datos**: SQL Server
- **Arquitectura**: Repository Pattern, Service Layer
- **Validaciones**: Form Requests personalizados
- **UI/UX**: Responsive design, modales, notificaciones

## Arquitectura del Sistema

El proyecto sigue las mejores prácticas de Laravel implementando:

- **Repository Pattern**: Para abstracción de datos
- **Service Layer**: Para lógica de negocio
- **Form Requests**: Para validaciones
- **Resource Controllers**: Para operaciones CRUD
- **Eloquent Relationships**: Para relaciones entre modelos

## Soporte y Contacto

Para cualquier consulta o problema:
- Revisa la documentación de Laravel: [https://laravel.com/docs](https://laravel.com/docs)
- Verifica que todos los requisitos estén instalados
- Asegúrate de que el servidor esté ejecutándose en el puerto 8000

## Licencia

Este proyecto está desarrollado bajo la licencia MIT de Laravel.
