CREATE DATABASE MetaScore;

USE MetaScore;

CREATE TABLE Usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    contrasenia VARCHAR(50) NOT NULL,
    admin VARCHAR(2) NOT NULL
);

CREATE TABLE Prensa (
    id_prensa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    contrasenia VARCHAR(50) NOT NULL
);

CREATE TABLE Videojuegos (
    id_videojuego INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    desarrolladora VARCHAR(50) NOT NULL,
    descripcion VARCHAR(1000) NOT NULL,
    imagen VARCHAR(1000) NOT NULL,
    Nota_Prensa INT,
    Nota_Usuarios INT
);

CREATE TABLE Peliculas (
    id_pelicula INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    distribuidora VARCHAR(50) NOT NULL,
    descripcion VARCHAR(1000) NOT NULL,
    imagen VARCHAR(1000) NOT NULL,
    Nota_Prensa INT,
    Nota_Usuarios INT
);

CREATE TABLE ResenasVideojuegos (
    id_votoVideojuego INT AUTO_INCREMENT PRIMARY KEY,
    id_videojuego INT,
    id_usuario INT,
    id_prensa INT,
    autor VARCHAR(50),
    nombre VARCHAR(50),
    resena VARCHAR(1000),
    nota INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_prensa) REFERENCES Prensa(id_prensa),
    FOREIGN KEY (id_videojuego) REFERENCES Videojuegos(id_videojuego)
);

CREATE TABLE ResenasPeliculas (
    id_votoPelicula INT AUTO_INCREMENT  PRIMARY KEY,
    id_pelicula INT,
    id_usuario INT,
    id_prensa INT,
    autor VARCHAR(50),
    nombre VARCHAR(50),
    resena VARCHAR(1000),
    nota INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_prensa) REFERENCES Prensa(id_prensa),
    FOREIGN KEY (id_pelicula) REFERENCES Peliculas(id_pelicula)
);

CREATE TABLE Favoritos (
    id_favorito INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    id_pelicula INT,
    id_videojuego INT,
    nombre varchar(50) NOT NULL,
    desarrolladora varchar(50),
    distribuidora varchar(50),
    imagen VARCHAR(1000) NOT NULL,
    Nota_Prensa INT,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_videojuego) REFERENCES Videojuegos(id_videojuego),
    FOREIGN KEY (id_pelicula) REFERENCES Peliculas(id_pelicula)
);

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Dead Space Remake 2", "EA", "Dead Space remake", "img/Videojuegos/dead-space-remake.png");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Resident Evil 4", "Capcom", "Susto susto", "img/Videojuegos/resident_evil_4_remake.png");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("The Legend Of Zelda: TOTK", "Nintendo", "The Legend of Zelda: Tears of the Kingdom es un videojuego de acción-aventura de 2023 de la serie The Legend of Zelda, desarrollado por la filial Nintendo EPD en colaboración con Monolith Soft y publicado por Nintendo para la consola Nintendo Switch.", "img/Videojuegos/zelda.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Dead Island 2", "Sumo Digital", "Dead Island 2 es un videojuego de acción y rol en primera persona ambientado en un mundo abierto infestado de Zombis. El juego ha sido desarrollado por Sumo Digital y distribuido por Kotch Media para las plataformas de PS4, PC y Xbox One.", "img/Videojuegos/dead_island_2.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Sekiro", "From Software", "Sekiro: Shadows Die Twice es un videojuego de acción y aventura desarrollado por From Software y distribuido por Activision. El juego fue lanzado el 22 de marzo de 2019 en las plataformas PlayStation 4, Xbox One y Microsoft Windows.", "img/Videojuegos/sekiro.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Super Mario Odyssey", "Nintendo", "Super Mario Odyssey es un videojuego de plataformas en tres dimensiones para Nintendo Switch desarrollado y publicado por Nintendo que se lanzó el 27 de octubre de 2017.", "img/Videojuegos/mario_odyssey.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Minecraft", "Mojang", "Minecraft es un videojuego de construcción de tipo «mundo abierto» o sandbox creado originalmente por el sueco Markus Persson (conocido comúnmente como «Notch»), y posteriormente desarrollado por Mojang Studios (actualmente parte de Microsoft)", "img/Videojuegos/minecraft.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Elden Ring", "From Software", "La historia de Elden Ring es la del Sinluz, un exiliado que regresa a un marchito y enorme reino conocido como las Tierras Intermedias. Su propósito: reclamar el poder del Círculo de Elden. Una gesta que lo enfrentará a criaturas de pesadilla y un cruel destino.", "img/Videojuegos/elden_ring.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("The Witcher 3: Wild Hunt", "CD Project", "The Witcher 3: Wild Hunt es un juego de rol de mundo abierto de nueva generación, y última entrega de la serie de juegos de CD Projekt RED con Geralt de Rivia como protagonista. Se estrenó el 19 de mayo de 2015 para PC, PlayStation 4 y Xbox One.", "img/Videojuegos/tw3.jpg");

INSERT into Videojuegos (nombre, desarrolladora, descripcion, imagen) values 
("Resident Evil 7", "Capcom", "Resident Evil 7 es el primer título de la saga principal que emplea una perspectiva en primera persona. A diferencia de otros videojuegos más cercanos al género del horror puro, como Amnesia: The Dark Descent y Outlast, el jugador controla a Ethan Winters.", "img/Videojuegos/re7.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Se7en", "New Line Cinema", "Se7en es una película de suspense psicológico dirigida por David Fincher y protagonizada por Brad Pitt y Morgan Freeman. La trama sigue a dos detectives, uno joven y ambicioso (Pitt) y otro a punto de retirarse (Freeman)", "img/Peliculas/Se7en.png");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Shutter Island", "New Line Cinema", "La historia cuenta la investigación de dos agentes federales enviados a una institución mental llamada Ashcliffe, con el fin de buscar a Rachel Solando, una paciente psicótica que ha escapado misteriosamente de su celda. Daniels (DiCaprio) tiene además en su mente los recuerdos del campo de concentración de Dachau.", "img/Peliculas/shutter_island.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Super Mario The Movie", "Illumination", "Adaptación de la serie de videojuegos de Nintendo. La película cuenta la historia de Mario y Luigi, dos hermanos que viajan a un mundo oculto para rescatar a la Princesa Peach, capturada por el malvado Rey Bowser.", "img/Peliculas/joker.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Joker", "Warner", "La película Joker (Guasón) de Todd Phillips muestra la manera en que Arthur Fleck (interpretado por Joaquin Phoenix) se convierte en Joker, el villano de ciudad Gótica y el archienemigo de Batman.", "img/Peliculas/joker.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Spider-Man: No Way Home", "Sony", "Por primera vez en la historia cinematográfica de Spider-Man la identidad de nuestro héroe de barrio de 17 años es revelada al mundo entero, poniendo en el ojo público su vida y la de sus seres queridos. ", "img/Peliculas/spiderman.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Sonic: the hedgehog 2", "Paramount", "Después de establecerse en Green Hills, Sonic quiere demostrar que tiene madera de héroe. La prueba de fuego llega con el retorno del malvado Robotnik, y su nuevo compinche, Knuckles, en busca de una esmeralda que destruye civilizaciones.", "img/Peliculas/sonic2.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Bullet Train", "Sony Pictures", "Cinco asesinos a sueldo se encuentran a bordo de un tren bala que viaja de Tokio a Morioka. Los sicarios descubrirán que sus misiones no son ajenas entre sí.", "img/Peliculas/bullet_train.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("DeadPool 2", "Marvel", "Deadpool trabaja ahora a escala internacional, eliminando a asesinos de masas, gánsteres, traficantes de personas y demás indeseables. Se creen intocables, pero Deadpool sabe cómo deshacerse de ellos de la forma más complicada, desmedida y sangrienta posible.", "img/Peliculas/dp2.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("Free Guy", "20th Century Studios", "Un cajero de un banco descubre que en realidad es un personaje sin papel dentro de un brutal videojuego de mundo interactivo.", "img/Peliculas/free_guy.jpg");

INSERT into Peliculas (nombre, distribuidora, descripcion, imagen) values 
("El Padrino", "Paramount", "Don Vito Corleone es el respetado y temido jefe de una de las cinco familias de la mafia de Nueva York en los años 40. El hombre tiene cuatro hijos: Connie, Sonny, Fredo y Michael, que no quiere saber nada de los negocios sucios de su padre. Cuando otro capo, Sollozzo, intenta asesinar a Corleone, empieza una cruenta lucha entre los distintos clanes.", "img/Peliculas/padrino.jpg");
