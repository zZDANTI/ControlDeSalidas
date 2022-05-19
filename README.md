# ControlDeSalidas
Proyecto control de salidas by Nicolas, Adrian, Jaime, Salvador

<b>Contextualización</b>

El objetivo es crear una práctica transversal a las asignaturas de BD, ED y LMSGI. En cada una
de ellas se desarrollará la parte correspondiente. Se crearán prácticas individuales por asignatura
donde se puntualizarán los detalles.

<b>Descripción</b>

Se desea desarrollar una aplicación web que permita llevar un control sobre las salidas de los
alumnos de la ESO del aula y requieran de autorización y revisión por parte del personal de
administración, profesorado de guardia o secretaría.
La aplicación ha de disponer de un listado de alumnos identificados por curso, de profesores,
personal de administración y secretaría, de manera que cuando un alumno tenga que salir del
aula se registre quién autoriza a salir, junto con la hora de salida y motivo. Por ejemplo, el alumno
tiene que ir urgentemente al aseo, tiene que llamar a casa, etc. Una vez el alumno llega a la zona
requerida, el responsable, que pueden ser profesor, de administración o secretaría, indica que ha
llegado y la hora. Del mismo modo, cuando el alumno termina el responsable registra que sale
para el aula y por último el profesor registra que ha llegado.
Si un alumno accede a algún lugar sin la debida autorización se registrará que ha accedido sin
permiso y el profesor con el que estaba en el aula, y se le enviará al aula para que el profesor
correspondiente realice la autorización.
De los alumnos, nos interesa conocer su NIA, que lo identifica; nombre, primer apellido y curso,
obligatorios, y segundo apellido.
De los profesores, personal de administración y secretaría, nos interesa conocer su email, que lo
identifica, nombre y primer apellido obligatorios, y su segundo apellido.
Para asegurar que sólo las personas autorizadas acceden a la aplicación se creará un login por
correo electrónico y contraseña. La contraseña ha de guardar los parámetros de seguridad
conteniendo al menos 6 dígitos entre al menos una mayúsculas, una minúsculas, un número y un
carácter especial. Las contraseñas se almacenarán encriptadas con el algoritmo BcCrypt.

<b>Práctica</b>

El objetivo es realizar el diseño de la práctica y utilizar todas las tecnologías vistas en el módulo
de ED. Para ello comenzaremos realizando los Wireframes, diseños de pantallas, con la mayor
concreción posible. Una vez realizado debe ser aprovado por todo el equipo y el profesor. Éste
debe ser el punto de partida para continuar con el diseño del modelo de datos de BD.
Todo trabajo realizado deberá tener su correspondiente tarea en Jira o Trello. Lo normal sería
definir una serie de tareas y que los integrantes del grupo se las vayan asignando. TODOS los
integrantes deben participar en todas las etapas, realizando alguna parte de ellas. Además han de
tener un conocimiento completo de lo realizado por los compañeros, puesto que las tareas serán
validadas/aprovadas por todos. El profesor podrá preguntar cualquier parte del proyecto a
cualquier integrante lo haya o no realizado él.
El proyecto será controlado con GIT con uso de ramas y repositorio remoto.
Se han de seguir las buenas prácticas de programación, como es el uso y nombrado de variables
correcto, comentarios, etc.
Antes de pasar a la fase de implementación realizaremos los diagramas UML vistos en clase,
incluido el diagrama de clases. Como la práctica no se implentará orientada o objetos haremos
una suposición como si sí lo hubieramos hecho o pensado para un futuro desarrollo.
Sería muy deseable, antes de pasar a la implementación, realizar los diseños de las pantallas tal
cual deben de quedar una vez implementadas.
