# Sistema de Control de Estacionamiento (Parking)

Sistema web para gestionar un estacionamiento de vehículos: reservas de plaza, clientes, facturación y envío de correos. Pensado para uso en aeropuertos o parkings con entrega/recogida de vehículo.

---

## Reconocimiento al autor original

Este proyecto **parte de** y está **basado en** el repositorio original:

**[sistema-parking-estacionamiento](https://github.com/urian121/sistema-parking-estacionamiento)** — desarrollado con PHP para el control de parking / parqueadero / estacionamiento.

- **Repositorio original:** [https://github.com/urian121/sistema-parking-estacionamiento](https://github.com/urian121/sistema-parking-estacionamiento)
- **Autor / Desarrollador original:** [urian121](https://github.com/urian121)

Se mantienen los derechos y el reconocimiento al autor original. Este código es un proyecto donde se aprenden aspectos importantes del desarrollo web; toda atribución y crédito corresponden al desarrollador original.

---

## Índice

1. [Reconocimiento al autor original](#reconocimiento-al-autor-original)
2. [¿De qué va la aplicación?](#de-qué-va-la-aplicación)
3. [Requisitos e instalación](#requisitos-e-instalación)
4. [Configuración](#configuración)
5. [Usuarios y roles](#usuarios-y-roles)
6. [Módulos y funcionalidades](#módulos-y-funcionalidades)
7. [Manual de uso](#manual-de-uso)
8. [Estructura del proyecto](#estructura-del-proyecto)
9. [Base de datos](#base-de-datos)
10. [Correo electrónico](#correo-electrónico)

---

## De qué va la aplicación

La aplicación permite:

- **Clientes**: registrarse, iniciar sesión, crear reservas de plaza (aire libre o cubierta), ver sus reservas y descargar PDFs.
- **Administradores**: gestionar agenda de reservas activas, reservas pendientes, historial, crear reservas en nombre de clientes, dar de alta/editar clientes, generar facturas y cambiar el estado de las reservas (pendiente → activa → finalizada).

**Flujo típico:**

1. El cliente (o el admin por él) crea una reserva indicando fechas, tipo de plaza, terminal, matrícula, etc.
2. El sistema calcula el importe según días y tipo de plaza (tablas de precios en BD).
3. Se envía un correo de aviso de reserva al cliente.
4. El administrador puede pasar la reserva a “Agenda” (activa) o a “Historial” (finalizada).
5. Se puede generar factura y enviar por email el enlace de descarga.

---

## Requisitos e instalación

### Requisitos

- **PHP** 7.4 o superior (recomendado 8.x), con extensiones: `mysqli`, `json`, `mbstring`
- **MySQL** o **MariaDB**
- Servidor web (Apache, Nginx) o servidor embebido de PHP

### Instalación

1. **Clonar o copiar** el proyecto en el directorio del servidor.

2. **Base de datos**
   - Crear la base de datos y el usuario si aplica:
     ```sql
     CREATE DATABASE bd_parking;
     ```
   - Importar el script SQL:
     ```bash
     mysql -u root -h 127.0.0.1 bd_parking < BD/bd_parking_2024-01-17.sql
     ```

3. **Configuración**
   - Editar `config/config.php` con servidor, usuario y contraseña de MySQL.
   - (Opcional) Editar `config/email_config.php` para el envío de correos (ver [Configuración](#configuración)).

4. **Levantar el servidor** (ejemplo con PHP embebido):
   ```bash
   php -S localhost:8080
   ```
   - Abrir en el navegador: `http://localhost:8080`

---

## Configuración

### Base de datos (`config/config.php`)

| Parámetro   | Descripción        | Ejemplo     |
|------------|--------------------|-------------|
| `$servidor`| Host MySQL         | `localhost` o `127.0.0.1` |
| `$usuario` | Usuario MySQL      | `root`      |
| `$password`| Contraseña MySQL  | `""`        |
| `$basededatos` | Nombre de la BD | `bd_parking` |

### Correo (`config/email_config.php`)

Configuración centralizada para PHPMailer (aviso de reserva, cuenta creada, factura):

- `username` / `password`: cuenta SMTP (para Gmail usar **clave de aplicación**).
- `from_email` / `from_name`: remitente.
- `reply_to`, `cc_copy`: opcionales.

Generar clave de aplicación Gmail: [Cuenta de Google → Seguridad](https://myaccount.google.com/security).

---

## Usuarios y roles

Hay **dos roles** definidos en el campo `rol` de `tbl_clientes`:

| Rol | Valor | Nombre        | Descripción |
|-----|--------|---------------|-------------|
| **Cliente**  | `0` | Usuario final | Puede crear su propia reserva, ver “Mis Reservas”, descargar reserva en PDF y editar su perfil. |
| **Administrador** | `1` | Admin        | Acceso a Agenda, Reservas pendientes, Crear reserva (por cliente), Clientes, Historial, facturas y cambio de estado de reservas. |

### Usuario de prueba (tras importar BD o crear manualmente)

Se puede usar un usuario administrador creado a mano, por ejemplo:

- **Email:** `admin@parking.com`
- **Contraseña:** `Parking123`
- **Rol:** Administrador (1)

*(Si no existe IdUser=1, hay que crearlo o usar los usuarios 21/22 del volcado SQL.)*

---

## Módulos y funcionalidades

### Público (sin login)

| Módulo / Página   | Ruta           | Descripción |
|-------------------|----------------|-------------|
| **Login**         | `index.php`    | Inicio de sesión (email + contraseña). Si ya hay sesión, redirige al dashboard. |
| **Crear cuenta**  | `crearCuenta.php` | Registro de nuevo cliente: nombre, DNI, dirección, email, teléfono, cómo nos conoció, observaciones, aceptación de términos. Tras guardar se envía email de bienvenida. |

### Dashboard – Cliente (rol = 0)

| Módulo      | Ruta          | Descripción |
|-------------|---------------|-------------|
| **Inicio**  | `dashboard/index.php` | Formulario para crear una reserva: fechas/horas entrega y recogida, tipo de plaza, terminales, matrícula, color, marca/modelo, nº vuelo, servicio adicional. Muestra el total a pagar. |
| **Mis Reservas** | `dashboard/Reservas.php` | Listado de reservas del cliente. Enlace para descargar cada reserva en PDF. |
| **Mi Perfil**    | `dashboard/MiPerfil.php` | Editar nombre, DNI, dirección, email, teléfono y contraseña. |

### Dashboard – Administrador (rol = 1)

| Módulo                | Ruta                      | Descripción |
|-----------------------|---------------------------|-------------|
| **Mi Agenda**         | `dashboard/Agenda.php`    | Reservas con **estado_reserva = 1** (activas). Permite ver detalle, generar factura, pasar a Historial y exportar a Excel. |
| **Reservas Pendientes** | `dashboard/ReservasPendientes.php` | Reservas con **estado_reserva = 0** (pendientes). Permite pasar a Agenda y exportar. |
| **Crear Reserva**     | `dashboard/CrearReserva.php` | Formulario de reserva (como el del cliente) más descuento, servicios extras y total. Crea la reserva y envía aviso por email al cliente. |
| **Clientes**          | `dashboard/CrearCliente.php` | Listado de clientes y formulario para crear o editar cliente (alta/edición desde admin). |
| **Historial de Reservas** | `dashboard/HistorialReservas.php` | Reservas con **estado_reserva = 2** (finalizadas). Exportar a Excel y enlaces a reserva/factura PDF. |

### Acciones y servicios (backend)

| Archivo / Ruta | Descripción |
|----------------|-------------|
| `acciones/login/acciones_login.php` | Procesa login: verifica email/contraseña, crea sesión (`IdUser`, `emailUser`, `rol`) y redirige al dashboard. |
| `acciones/login/exit.php` | Cierra sesión y redirige al login. |
| `acciones/login/CreateUser.php` | Registro de nuevo cliente desde `crearCuenta.php`; envía a `emails/cuenta_creada_email.php`. |
| `acciones/servicio_api/api_dias_reserva.php` | API POST: recibe `tipo_plaza` y `total_dias`, devuelve el precio desde `tbl_parking_aire_libre` o `tbl_parking_cubierto`. |
| `acciones/servicio_api/cambiarStatusReserva.php` | API POST: cambia `estado_reserva` de una reserva (0↔1↔2) según si viene de Reservas Pendientes o de Agenda. |
| `acciones/exportDataReservas.php` | Exporta reservas a Excel (.xls) según parámetro `expo` (0=pendientes, 1=activas, 2=historial). |
| `dashboard/funciones.php` | Lógica principal: crear/actualizar perfil, crear reserva (cliente y admin), crear factura, listar reservas/clientes, actualizar cliente desde admin. |
| `dashboard/ReservaPDF.php` | Genera PDF de una reserva (por `idReserva`). |
| `dashboard/FacturaClientePDF.php` | Genera PDF de factura (por `idReserva`). |
| `dashboard/ModalCrearFactura.php` | Modal/formulario para crear factura (formato de pago, servicios extras, etc.) y enviar email con enlace a factura PDF. |

---

## Manual de uso

### Cómo usar la aplicación

1. **Acceso**
   - Abrir la URL del proyecto (ej. `http://localhost:8080`).
   - Si no tienes cuenta: “Crear una cuenta” → rellenar formulario → aceptar términos → enviar. Recibirás un email de bienvenida.
   - Si ya tienes cuenta: email + contraseña → “Iniciar sesión”.

2. **Cliente (rol 0)**
   - **Inicio:** Crear reserva eligiendo fechas, tipo de plaza (Aire libre / Cubierto), terminales, matrícula, etc. El total se calcula solo. Enviar formulario.
   - Tras crear la reserva se envía un correo de aviso.
   - **Mis Reservas:** Ver todas tus reservas y descargar el PDF de cada una.
   - **Mi Perfil:** Cambiar datos personales y contraseña.

3. **Administrador (rol 1)**
   - **Reservas Pendientes:** Ver reservas recién creadas (estado 0). Opción “Pasar a Agenda” para marcarlas como activas.
   - **Mi Agenda:** Ver reservas activas (estado 1). Aquí puedes abrir detalle, crear factura (modal) y “Pasar a Historial” cuando terminen.
   - **Crear Reserva:** Igual que el cliente pero eligiendo el cliente y pudiendo añadir descuento y servicios extras.
   - **Clientes:** Ver lista, “Crear cuenta cliente” o editar uno existente (enlace con `idCliente`).
   - **Historial de Reservas:** Ver reservas finalizadas (estado 2) y exportar o descargar reserva/factura PDF.

4. **Factura (solo admin)**
   - Desde Agenda, en la reserva: botón/acción “Factura” → se abre el modal de factura.
   - Completar formato de pago, servicios extras si aplica, y confirmar. Se actualiza la reserva y se envía al cliente un email con enlace a la factura en PDF.

5. **Cerrar sesión**
   - Menú superior derecha (email) → “Cerrar sesión”.

---

## Estructura del proyecto

```
sistema-parking-estacionamiento/
├── acciones/              # Lógica de login, APIs y exportaciones
│   ├── login/             # Login, registro, salir
│   └── servicio_api/      # API días/precio, cambiar estado reserva
├── assets/                # CSS, JS, imágenes (front)
├── basesLogin/            # Head/footer para login y crear cuenta
├── BD/                    # Script SQL de la base de datos
├── config/
│   ├── config.php        # Conexión MySQL
│   └── email_config.php  # Configuración PHPMailer
├── dashboard/             # Panel según rol
│   ├── bases/            # Nav, navbar, head, loader, etc.
│   ├── Agenda.php        # Reservas activas (admin)
│   ├── ReservasPendientes.php
│   ├── HistorialReservas.php
│   ├── CrearReserva.php   # Alta reserva (admin)
│   ├── CrearCliente.php  # ABM clientes (admin)
│   ├── Reservas.php      # Mis reservas (cliente)
│   ├── MiPerfil.php      # Perfil (todos)
│   ├── funciones.php    # Acciones POST del dashboard
│   ├── ReservaPDF.php / FacturaClientePDF.php
│   └── ...
├── emails/               # Envío de correos (reserva, cuenta, factura)
├── PHPMailer/            # Librería PHPMailer
├── index.php             # Página de login
├── crearCuenta.php       # Registro público
└── msjs.php             # Mensajes toast (éxito/error)
```

---

## Base de datos

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| **tbl_clientes** | Usuarios: email, contraseña (bcrypt), nombre, DNI, dirección, teléfono, conocido_por, observaciones, terminos, **rol** (0=cliente, 1=admin), sesión, fecha creación. |
| **tbl_reservas** | Reservas: id_cliente, fechas/horas entrega y recogida, tipo_plaza, terminales, matrícula, color, marca_modelo, nº vuelo, servicio_adicional, total_pago_reserva, descuento, formato_pago, servicios_extras, total_gasto_extras, **estado_reserva** (0=pendiente, 1=activa, 2=finalizada), fecha_pago_factura, etc. |
| **tbl_parking_aire_libre** | Precios por número de días (plaza aire libre): `dia`, `valor`. |
| **tbl_parking_cubierto** | Precios por número de días (plaza cubierta): `dia`, `valor`. |

### Estados de reserva (`estado_reserva`)

| Valor | Significado     | Dónde se muestra      |
|-------|-----------------|------------------------|
| 0     | Pendiente       | Reservas Pendientes   |
| 1     | Activa          | Mi Agenda             |
| 2     | Finalizada      | Historial de Reservas  |

---

## Correo electrónico

La configuración está centralizada en `config/email_config.php`. Los scripts en `emails/` envían:

| Script | Cuándo se usa | Contenido |
|--------|----------------|-----------|
| `cuenta_creada_email.php` | Tras registrar un nuevo cliente (crear cuenta) | Bienvenida y enlace para acceder. |
| `aviso_reserva_email.php` | Tras crear una reserva (cliente o admin) | Aviso de reserva al email del cliente. |
| `factura_email.php` | Tras crear/registrar la factura desde el modal (admin) | Enlace para descargar la factura en PDF. |

Para que los correos se envíen correctamente, hay que configurar en `config/email_config.php` el usuario y la contraseña (o clave de aplicación) del servidor SMTP.

---

## Resumen rápido por rol

| Acción | Cliente (rol 0) | Administrador (rol 1) |
|--------|------------------|------------------------|
| Iniciar sesión | ✅ | ✅ |
| Crear cuenta (pública) | ✅ | ✅ |
| Crear reserva propia | ✅ (Inicio) | ✅ (Crear Reserva, por cliente) |
| Ver mis reservas | ✅ (Mis Reservas) | — |
| Ver agenda activa | — | ✅ (Mi Agenda) |
| Ver pendientes | — | ✅ (Reservas Pendientes) |
| Ver historial | — | ✅ (Historial de Reservas) |
| Gestionar clientes | — | ✅ (Clientes) |
| Generar factura | — | ✅ (desde Agenda) |
| Cambiar estado reserva | — | ✅ (Pendiente → Agenda → Historial) |
| Exportar Excel | — | ✅ (en Agenda, Pendientes, Historial) |
| Mi Perfil | ✅ | ✅ |

---

## Créditos y derechos

Este proyecto **parte de** el repositorio original **[sistema-parking-estacionamiento](https://github.com/urian121/sistema-parking-estacionamiento)** de [urian121](https://github.com/urian121). Se mantienen los derechos del autor original y se le reconoce como desarrollador del proyecto base.

---

*Sistema de Control de Estacionamiento — Documentación y manual de uso. Basado en el proyecto original de [urian121](https://github.com/urian121).*
