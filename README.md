# prueba_tecnica_foreach_cdo
Prueba técnica para la selección de desarrollador full-stack para CDO HR


### Requerimientos Backend
    - Apache - PHP
    - Mysql 

- Configurar Apache para que considere el directorio base: [/backend/htdocs](/backend/htdocs)
- Verificar que funcione correctamente la configuración del [.htaccess](/backend/htdocs/.htaccess)

Para configurar la base de datos MySQL debe setear las siguientes variables de entorno:
```SH
   DB_USER # Usuario de la base de datos
   DB_PASS # Password del usuario
   DB_NAME # Nombre de la base de datos
   DB_SERV # Servidor de la base de datos
```

 - Importar manualmente la estructura de la base de datos y los datos de la tabla transporte ubicados en el archivo [bd.sql](/backend/bd.sql)

 
### Requerimientos Front-End:
    - Angular CLI: 17.3.7
    - Node: 20.13.1
    - Package Manager: npm 10.5.2

### Instrucciones de despliegue en desarrollo
Para correr la aplicación front-end desarrollada en *Angular 17*, la cual se encuentra en el directorio [/frontend/ptecnicafront](/frontend/ptecnicafront) se debe contar on los requerimientos previamente indicados (node, angular-cli).

- Comprobar la instalación de todas las dependencias: `npm install`

- Iniciar Servidor de desarrollo de angular-cli
`ng serve -o `

#### Configuración de la ruta backend API

Para configurar la ruta donde estará corriendo la aplicación de backend debe modificar el archivo [app.condig.ts](/frontend/ptecnicafront/src/app/app.config.ts) indicando la ruta final.

```TS
    export const API_CONFIG = {
        api_url: "http://localhost/"
    }
```