Hola!, Primero que todo agradezco por continuar con mi proceso para la vacante de desarrollador fullstack junior.

Espero que les haya gustado tanto el diseño, como la funcionalidad y las nuevas funcionalidades también y en general la aplicación general 😁💻

Cualquier duda o problema, mi número de contacto es: 3005999369 y correo jeandeveloper04@gmail.com


#  Sistema de Cotización de Seguros Vehiculares

Este proyecto es una aplicación web que permite a los usuarios ingresar información personal y la placa de su vehículo para consultar planes de seguros disponibles. La app realiza validaciones en frontend y envía los datos a una API desarrollada en PHP para retornar ofertas simuladas.

## Tecnologías utilizadas

- HTML5 / Bootstrap 5
- JavaScript / jQuery / SweetAlert2
- PHP (API RESTful)
- MySQL

---

## Requisitos

Antes de comenzar asegúrate de tener instalado:

- PHP 7.4 o superior
- MySQL o MariaDB
- Servidor Apache o similar (XAMPP, Laragon, etc.)
- Composer (opcional pero recomendado, si deseas estructurar como proyecto PHP moderno)

---

## Instalación

1. **Ingrese a su carpeta xampp > htdocs:**
 - Dentro de htdocs cree una carpeta vacia con el nombre que desee

   ![image](https://github.com/user-attachments/assets/a9d405ec-f12b-4a27-a6d4-ab8b127d3f3d)

   ->

   ![image](https://github.com/user-attachments/assets/bccb3f56-d734-447a-acc5-ad7ee4dc2383)

   ->

   ![image](https://github.com/user-attachments/assets/7db650f9-498b-4f67-a4e0-1261171cfdc6)

2. **Ir a su visual studio code:**
 - Dentro del VSC proceda a abrir una terminal con (CTRL + SHIFT + Ñ) y proceda a dirigirse a la ruta de la nueva carpeta anteriormente creada.

   ![image](https://github.com/user-attachments/assets/cabc9208-74d5-4351-9da0-acf5c58cd755)

 - Una vez dentro de la ruta proceda a ir al github del repositorio del proyecto (https://github.com/Pool2004/Grupo-Asistencia.git)

   ![image](https://github.com/user-attachments/assets/44cf021c-e60e-4a68-9a68-6527a78b9771)

3. **Proceda a clonar el repositorio:**
 - git clone -b develop https://github.com/Pool2004/Grupo-Asistencia.git
4. **Una vez clonado proceda a ir:**
 - A la rama develop (git checkout develop) y proceda a bajar los cambios (git pull origin develop)

5. **El proyecto le deberia quedar**

  Carpeta nueva creada:

  ![image](https://github.com/user-attachments/assets/042d5636-32f3-493f-b9a5-532b89937b38)

  Dentro de esta:

  ![image](https://github.com/user-attachments/assets/0af1fd83-05b7-4dc0-824b-6be626e87f26)


  ---

  ## Uso

  1. **Dirigirse a la ruta localhost/Entrevista (Recuerde tener sus servicios del xampp encendidos tanto apache como mysql)

  ![image](https://github.com/user-attachments/assets/f516d743-f1a1-4434-835f-3663a659404a)

  2. **En el login:**
     - Puede registrar un usuario agente de la aseguradora en el apartado de registrarse
       
       ![image](https://github.com/user-attachments/assets/867a7131-1246-423f-8d83-c4277bbdb6bd)

     - Si olvido la contraseña dirigirse a "¿Olvidaste tu contraseña?" y ingresar el correo que fue registrado
    
       ![image](https://github.com/user-attachments/assets/edfc1f16-ed90-44a3-9483-bb9752d8065f)

     - En caso de solo querer ingresar puede usar el usuario de prueba:
        **Correo: pruebacorreo@gmail.com**
        **Contrasena: $Admin123**
  3. **En el dashboard:**

      ![image](https://github.com/user-attachments/assets/25064c0e-9ff0-4fb0-85b0-5324aa8e11ff)

     Tenemos unos datos dinámicos como nombre y rol y algunos datos de simulación para mayor estilo (Gráfica y datos de las cards)

     - **En el sidebar:**
    
     ![image](https://github.com/user-attachments/assets/c4a9b28e-280e-4816-b51c-12eb186747de)

     **Opción Añadir Planes:**
        - Sirve para agregar un nuevo plan al sistema mediante un pequeño formulario

        ![image](https://github.com/user-attachments/assets/80b8d4a5-3454-4cdb-8feb-3b759a4c77e4)

       ... Agregue los campos y proceda con "Agregar Plan"



     **Opción Planes Activos:**
       - Sirve para visualizar los planes activos
    
         ![image](https://github.com/user-attachments/assets/ad3d43f1-10c3-48e8-86b9-c1b26c3fcbd4)

       - En la parte de "Acción" Contamos con un botón de lápiz para editar un plan
    
       ![image](https://github.com/user-attachments/assets/c6eb14b4-ebd3-4045-9f21-f83fc9b01801)

         ->

       ![image](https://github.com/user-attachments/assets/1a7c130a-ce90-45d6-bab1-56be2d0e0bf8)

      Llene los campos y actualice.


      - En la parte de "Acción" contamos con un botón de bote de basura para eliminar un plan
    
     ![image](https://github.com/user-attachments/assets/cb20dfa2-e04c-432c-a9df-5da969883fef)

     Al dar click, el sistema preguntara para validar la eliminación del registro

     ![image](https://github.com/user-attachments/assets/eb066de6-6b20-4164-84c6-8311970f4274)

     **Opción Asegurar Ahora ó Asegurar > Asegurar:**
        - Sirve para cargar un formulario y cotizar un plan para un vehículo

        ![image](https://github.com/user-attachments/assets/57150d94-8ec9-427a-8fc8-81c0f0e6bc42)

       Ingrese los campos y dele a "cotizar" se le debera mostrar n cantidad de opciones de oferta para cotizar el seguro del vehículo"

     ![image](https://github.com/user-attachments/assets/9cc6752d-5ea7-43f4-9bf8-629699ca4ada)


     **Recuerde previamente haber creado planes**


     ---

     **Funcionalidades extras**


     **Soporte/Chat** -> Dirige al whatsapp de grupo asistencia

     ![image](https://github.com/user-attachments/assets/9a9c5153-c012-411e-8f8a-2c84c4cd28b7)


     ->

     ![image](https://github.com/user-attachments/assets/88f8a47a-a9e9-40a5-9891-4c0e595c0ccb)


     **Botón <<** -> Sirve para minimizar el sidebar

     ![image](https://github.com/user-attachments/assets/6ca66e6d-7395-4ebf-b4c9-33d2b43aa784)


     ->

     ![image](https://github.com/user-attachments/assets/820dfdbc-5466-4a62-a785-d1ca7226cfbc)


     **Botón campana** -> Simulación de notificaciones dentro del sistema


     ![image](https://github.com/user-attachments/assets/b01f3f00-da1a-4e04-a670-275f6fcd03f8)


     **Botón usuario** -> Abre un dialogo que permite ver los términos y condiciones (Al dar click dirige al archivo de términos y condiciones)


     ![image](https://github.com/user-attachments/assets/59749497-46b5-448b-916e-116d0050fc0f)


     ->

     ![image](https://github.com/user-attachments/assets/9a929ce8-7a0f-4e35-a9a8-e77792d09151)



     **Botón cerrar sesión** -> Sirve para cerrar sesión y dirige de nuevo al index


     ![image](https://github.com/user-attachments/assets/ee2bd90e-f954-483c-9ba4-f00748231858)


     **Recuperación de cuenta** -> En olvidastes contraseña al ingresar el correo y restaurar contraseña el sistema envia vía correo (gmail) de forma automática un correo de recuperación


     ![image](https://github.com/user-attachments/assets/9cae8f83-a952-477b-9302-067524e44294)



     ->

     ![image](https://github.com/user-attachments/assets/344de4b1-e1d1-4f0b-ba41-5847245377fa)


     ->

     ![image](https://github.com/user-attachments/assets/3c242cdc-a36c-4c02-beab-2647077009e5)


     En su correo deberia llegar un correo de recuperación como este


     ![image](https://github.com/user-attachments/assets/08e2bbbb-04eb-43c2-9bae-ef0f85cadf58)


     ->

     ![image](https://github.com/user-attachments/assets/5ade8afd-4792-4472-96cd-6116dbff8fe4)


     Al dar click en restaurar contraseña deberia

     ![image](https://github.com/user-attachments/assets/98757b23-494a-4d9f-a547-9fd4a125db8e)


     Donde podra establecer su nueva contraseña.



     ---


     Endpoints

     **API WS**

     METHOD: GET -> ENDPOINT: http://localhost/Entrevista/Api-WS/index.php/planes

     EJEMPLO SOLICITUD RESPUESTA

     ![image](https://github.com/user-attachments/assets/cac86a95-30eb-4dde-b34b-c8d9ad24ffe9)


    METHOD: POST -> ENDPOINT: http://localhost/Entrevista/Api-SGA/index.php/crear

     EJEMPLO DEL BODY DEL JSON A ENVIAR

     ![image](https://github.com/user-attachments/assets/c3468fe0-a2a6-4303-9980-8c7ce3bb403f)



     EJEMPLO SOLICITUD RESPUESTA

     ![image](https://github.com/user-attachments/assets/a89294fa-8c01-4809-8516-26effaea9b67)




     METHOD: DELETE -> ENDPOINT: http://localhost/Entrevista/Api-WS/index.php/eliminar

     EJEMPLO DEL BODY DEL JSON A ENVIAR

     ![image](https://github.com/user-attachments/assets/aa79fef0-02c8-408a-aae0-3999bc54558a)




     EJEMPLO SOLICITUD RESPUESTA

     ![image](https://github.com/user-attachments/assets/fb68f8d8-1749-4e86-acad-9fec7cf1d05d)


     METHOD: PUT -> ENDPOINT: http://localhost/Entrevista/Api-WS/index.php/actualizar

     ![image](https://github.com/user-attachments/assets/2c6c4d00-4013-4700-8874-08d0cd9ca3ec)



     METHOD: GET -> ENDPOINT: http://localhost/Entrevista/Api-WS/index.php/planes

     ![image](https://github.com/user-attachments/assets/0d61627e-a1c6-4407-a5c7-20660f5206a9)



     **API SGA**

     METHOD: POST -> ENDPOINT: http://localhost/Entrevista/Api-SGA/index.php/crear

     EJEMPLO DEL BODY DEL JSON A ENVIAR

     ![image](https://github.com/user-attachments/assets/dd3083d7-d413-48d9-abc4-fea1278969c8)


     EJEMPLO SOLICITUD RESPUESTA

     ![image](https://github.com/user-attachments/assets/a89294fa-8c01-4809-8516-26effaea9b67)




     METHOD: DELETE -> ENDPOINT: http://localhost/Entrevista/Api-SGA/index.php/eliminar

     EJEMPLO DEL BODY DEL JSON A ENVIAR

     ![image](https://github.com/user-attachments/assets/ed73913d-49f2-467b-b797-f245df90e921)



     EJEMPLO SOLICITUD RESPUESTA

     ![image](https://github.com/user-attachments/assets/b5a2a85c-7124-4270-b254-4483757bd6e9)

     METHOD: PUT -> ENDPOINT: http://localhost/Entrevista/Api-SGA/index.php/actualizar

     ![image](https://github.com/user-attachments/assets/53ed28c5-697d-4e84-9eeb-a5e12cbedbef)


     METHOD: GET -> ENDPOINT: http://localhost/Entrevista/Api-SGA/index.php/planes

     ![image](https://github.com/user-attachments/assets/a0b3a38b-8c82-41f8-90f1-83e507b151ec)





     


     












     











   
   




