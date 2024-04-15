CREATE TABLE userU(
   idUser INT,
   pseudo VARCHAR(50)  NOT NULL,
   mail VARCHAR(50) ,
   password VARCHAR(150) ,
   isAdmin BOOLEAN,
   favoriteGenre VARCHAR(50) ,
   favoriteGroup VARCHAR(50) ,
   favoriteGuitarist VARCHAR(50) ,
   bio VARCHAR(50) ,
   PRIMARY KEY(idUser),
   UNIQUE(pseudo)
);

CREATE TABLE guitarist(
   idGuitarist INT,
   name VARCHAR(50)  NOT NULL,
   groupG VARCHAR(150) ,
   bio VARCHAR(500) ,
   dated DATETIME,
   PRIMARY KEY(idGuitarist),
   UNIQUE(name)
);

CREATE TABLE album(
   title VARCHAR(50) ,
   yearY INT,
   PRIMARY KEY(title)
);

CREATE TABLE gear(
   idGear INT,
   name VARCHAR(50) ,
   brand VARCHAR(50) ,
   PRIMARY KEY(idGear)
);

CREATE TABLE music(
   idMusic INT,
   name VARCHAR(50) ,
   title VARCHAR(50) ,
   PRIMARY KEY(idMusic),
   FOREIGN KEY(title) REFERENCES album(title)
);

CREATE TABLE guitar(
   idGear INT,
   yearY INT,
   PRIMARY KEY(idGear),
   FOREIGN KEY(idGear) REFERENCES gear(idGear)
);

CREATE TABLE amp(
   idGear INT,
   powerP VARCHAR(50) ,
   technology VARCHAR(50) ,
   PRIMARY KEY(idGear),
   FOREIGN KEY(idGear) REFERENCES gear(idGear)
);

CREATE TABLE pedal(
   idGear INT,
   effect VARCHAR(50) ,
   PRIMARY KEY(idGear),
   FOREIGN KEY(idGear) REFERENCES gear(idGear)
);

CREATE TABLE contribution(
   idContribution INT,
   dateD DATETIME,
   idMusic INT NOT NULL,
   idGear INT NOT NULL,
   idUser INT NOT NULL,
   PRIMARY KEY(idContribution),
   UNIQUE(idGear),
   FOREIGN KEY(idMusic) REFERENCES music(idMusic),
   FOREIGN KEY(idGear) REFERENCES gear(idGear),
   FOREIGN KEY(idUser) REFERENCES userU(idUser)
);

CREATE TABLE favorite(
   idUser INT,
   idGuitarist INT,
   PRIMARY KEY(idUser, idGuitarist),
   FOREIGN KEY(idUser) REFERENCES userU(idUser),
   FOREIGN KEY(idGuitarist) REFERENCES guitarist(idGuitarist)
);

CREATE TABLE play(
   idGuitarist INT,
   idMusic INT,
   PRIMARY KEY(idGuitarist, idMusic),
   FOREIGN KEY(idGuitarist) REFERENCES guitarist(idGuitarist),
   FOREIGN KEY(idMusic) REFERENCES music(idMusic)
);
