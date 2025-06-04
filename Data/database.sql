DROP TABLE IF EXISTS MESSAGES;
DROP TABLE IF EXISTS TRANSACTIONS;
DROP TABLE IF EXISTS WISHLIST;
DROP TABLE IF EXISTS SHOPPINGCART;
DROP TABLE IF EXISTS PRODUCT_GENRE;
DROP TABLE IF EXISTS PRODUCT_IMAGE;
DROP TABLE IF EXISTS PRODUCT;
DROP TABLE IF EXISTS GENRE;
DROP TABLE IF EXISTS IMAGES;
DROP TABLE IF EXISTS DEVICE;
DROP TABLE IF EXISTS USER;

CREATE TABLE USER (
    UserName NVARCHAR(50) NOT NULL PRIMARY KEY,
    Email NVARCHAR(160) NOT NULL UNIQUE,
    FullName NVARCHAR(60),
    Password NVARCHAR(20) NOT NULL,
    Admin BOOLEAN DEFAULT 0,
    Blocked BOOLEAN DEFAULT 0
);

CREATE TABLE DEVICE (
    DEVICEId INTEGER NOT NULL PRIMARY KEY,
    DEVICEName NVARCHAR(50) NOT NULL
);

CREATE TABLE PRODUCT (
    PRODUCTId INTEGER NOT NULL PRIMARY KEY,
    ProductName NVARCHAR(50) NOT NULL,
    Price INTEGER NOT NULL CHECK(Price > 0),
    Description NVARCHAR(255) NOT NULL,
    Developer NVARCHAR(60) NOT NULL,
    UserName NVARCHAR(50) NOT NULL,
    DEVICEId INTEGER NOT NULL,
    sold INTEGER NOT NULL,
    FOREIGN KEY (UserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (DEVICEId) REFERENCES DEVICE (DEVICEId) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE GENRE (
    GENREName NVARCHAR(50) NOT NULL PRIMARY KEY
);

CREATE TABLE PRODUCT_GENRE (
    PRODUCTId INTEGER NOT NULL,
    GENREName NVARCHAR(50) NOT NULL,
    FOREIGN KEY (PRODUCTId) REFERENCES PRODUCT (PRODUCTId) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (GENREName) REFERENCES GENRE (GENREName) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE WISHLIST (
    PRODUCTId INTEGER NOT NULL,
    UserName NVARCHAR(50) NOT NULL,
    FOREIGN KEY (PRODUCTId) REFERENCES PRODUCT (PRODUCTId) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (UserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE SHOPPINGCART (
    PRODUCTId INTEGER NOT NULL,
    UserName NVARCHAR(50) NOT NULL,
    FOREIGN KEY (PRODUCTId) REFERENCES PRODUCT (PRODUCTId) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (UserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE IMAGES (
    IMAGESId INTEGER NOT NULL PRIMARY KEY,
    LINK TEXT NOT NULL
);

CREATE TABLE PRODUCT_IMAGE (
    IMAGESId INTEGER NOT NULL,
    PRODUCTId INTEGER NOT NULL,
    FOREIGN KEY (PRODUCTId) REFERENCES PRODUCT (PRODUCTId) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (IMAGESId) REFERENCES IMAGES (IMAGESId) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE TRANSACTIONS (
    TRANSACTIONSId INTEGER NOT NULL,
    PRODUCTId INTEGER NOT NULL,
    UserName NVARCHAR(50) NOT NULL,
    Address NVARCHAR(160) NOT NULL,
    FOREIGN KEY (PRODUCTId) REFERENCES PRODUCT (PRODUCTId) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (UserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE MESSAGES (
    MESSAGEId INTEGER NOT NULL PRIMARY KEY,
    SenderUserName NVARCHAR(50) NOT NULL,
    ReceiverUserName NVARCHAR(50) NOT NULL,
    TimeSent DATETIME,
    Seen BOOLEAN DEFAULT 0,
    MessageText NVARCHAR(255) NOT NULL,
    FOREIGN KEY (SenderUserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (ReceiverUserName) REFERENCES USER (UserName) ON UPDATE CASCADE ON DELETE CASCADE
);

-- POPULATE THE TABLES
-- Inserting data into USER table
INSERT INTO USER (UserName, Email, FullName, Password, Admin, Blocked)
VALUES 
('johnDoe', 'john.doe@example.com', 'John Doe', 'password123', 1, 0),
('janeDoe', 'jane.doe@example.com', 'Jane Doe', 'password456', 0, 0),
('aliceSmith', 'alice.smith@example.com', 'Alice Smith', 'password789', 0, 0),
('bobSmith', 'bob.smith@example.com', 'Bob Smith', 'password101', 0, 0),
('emilyJones', 'emily.jones@example.com', 'Emily Jones', 'password202', 0, 0),
('mikeBrown', 'mike.brown@example.com', 'Mike Brown', 'password303', 0, 0),
('saraWilson', 'sara.wilson@example.com', 'Sara Wilson', 'password404', 0, 0),
('chrisTaylor', 'chris.taylor@example.com', 'Chris Taylor', 'password505', 0, 0),
('lisaJohnson', 'lisa.johnson@example.com', 'Lisa Johnson', 'password606', 0, 0),
('ryanMiller', 'ryan.miller@example.com', 'Ryan Miller', 'password707', 0, 0),
('amyLee', 'amy.lee@example.com', 'Amy Lee', 'password808', 1, 0),
('davidWhite', 'david.white@example.com', 'David White', 'password909', 0, 0),
('maryClark', 'mary.clark@example.com', 'Mary Clark', 'password010', 0, 0),
('steveWilson', 'steve.wilson@example.com', 'Steve Wilson', 'password111', 0, 0),
('lindaBrown', 'linda.brown@example.com', 'Linda Brown', 'password212', 0, 0),
('tomJones', 'tom.jones@example.com', 'Tom Jones', 'password313', 0, 0),
('karenTaylor', 'karen.taylor@example.com', 'Karen Taylor', 'password414', 0, 0),
('kevinDavis', 'kevin.davis@example.com', 'Kevin Davis', 'password515', 0, 0),
('juliaMartin', 'julia.martin@example.com', 'Julia Martin', 'password616', 0, 0),
('nickJohnson', 'nick.johnson@example.com', 'Nick Johnson', 'password717', 0, 0);

-- Inserting data into DEVICE table
INSERT INTO DEVICE (DEVICEId, DEVICEName)
VALUES 
(1, 'Xbox One'),
(2, 'PlayStation'),
(3, 'Nintendo Switch'),
(4, 'PC'),
(5, 'Xbox Series S'),
(6, 'Nintendo Wii');

-- Inserting data into PRODUCT table
INSERT INTO PRODUCT (PRODUCTId, ProductName, Price, Description, Developer, UserName, DEVICEId, sold)
VALUES 
(1, 'Super Mario Bros.', 29, 'A classic side-scrolling platformer where players control Mario as he journeys through the Mushroom Kingdom to rescue Princess Peach from the evil Bowser.', 'Nintendo', 'johnDoe', 3,0),
(2, 'The Legend of Zelda', 29, 'An iconic action-adventure game where players control Link as he embarks on a quest to rescue Princess Zelda and defeat the evil Ganon.', 'Nintendo', 'johnDoe', 3,0),
(3, 'Pac-Man', 19, 'An arcade classic where players control Pac-Man as he navigates through a maze, eating dots and avoiding ghosts.', 'Namco', 'janeDoe', 4,0),
(4, 'Tetris', 19, 'A puzzle game where players must rotate and arrange falling blocks to create complete horizontal lines.', 'Alexey Pajitnov', 'aliceSmith', 4,0),
(5, 'Super Metroid', 29, 'A critically acclaimed action-adventure game where players control Samus Aran as she explores the planet Zebes and battles space pirates.', 'Nintendo', 'aliceSmith', 3,0),
(6, 'Mega Man 2', 29, 'A platformer where players control Mega Man as he battles through a series of levels, defeating robot masters and collecting their powers.', 'Capcom', 'bobSmith', 2,0),
(7, 'Sonic the Hedgehog', 19, 'A fast-paced platformer where players control Sonic as he races through levels, collecting rings and thwarting the evil plans of Dr. Robotnik.', 'Sega', 'emilyJones', 4,0),
(8, 'Donkey Kong', 19, 'An arcade classic where players control Jumpman (later known as Mario) as he climbs ladders and avoids obstacles to rescue his girlfriend, Pauline, from Donkey Kong.', 'Nintendo', 'mikeBrown', 6,0),
(9, 'Street Fighter II', 29, 'A fighting game where players select from a roster of characters and compete in one-on-one battles against opponents from around the world.', 'Capcom', 'saraWilson', 2,0),
(10, 'Final Fantasy VI', 29, 'An epic role-playing game where players control a group of heroes as they journey across the world to stop the nefarious plans of the Empire.', 'Square', 'chrisTaylor', 4,0),
(11, 'Chrono Trigger', 29, 'A beloved RPG where players control a group of adventurers as they travel through time to prevent a global catastrophe.', 'Square', 'lisaJohnson', 4,0),
(12, 'The Oregon Trail', 19, 'An educational simulation game where players guide a wagon train of settlers from Missouri to Oregon, facing various challenges along the way.', 'MECC', 'lisaJohnson', 4,0),
(13, 'Space Invaders', 19, 'An iconic arcade shooter where players control a ship at the bottom of the screen, shooting aliens as they descend towards Earth.', 'Taito', 'ryanMiller', 4,0),
(14, 'Castlevania', 19, 'A classic action-platformer where players control Simon Belmont as he battles through Dracula''s castle, defeating monsters and bosses along the way.', 'Konami', 'ryanMiller', 1,0),
(15, 'Doom', 19, 'A groundbreaking first-person shooter where players control a space marine as he battles demons from Hell on the moons of Mars.', 'id Software', 'amyLee', 4,0),
(16, 'GoldenEye 007', 29, 'A first-person shooter based on the James Bond film, where players control Bond as he infiltrates a secret Soviet facility and uncovers a plot to destroy the world.', 'Rare', 'amyLee', 5,0),
(17, 'Pokémon Red and Blue', 29, 'Role-playing games where players embark on a journey to become the Pokémon Champion, capturing and training Pokémon to battle against other trainers.', 'Game Freak', 'davidWhite', 4,0),
(18, 'Super Mario Kart', 29, 'A kart racing game where players select from a roster of characters from the Mario universe and compete in races across a variety of tracks.', 'Nintendo', 'maryClark', 6,0),
(19, 'SimCity 2000', 19, 'A city-building simulation game where players design and manage their own city, balancing the needs of residents with the limitations of resources and space.', 'Maxis', 'steveWilson', 5,0),
(20, 'Civilization II', 29, 'A turn-based strategy game where players control a civilization from ancient times to the modern era, competing with other civilizations for dominance.', 'MicroProse', 'steveWilson', 4,0);

-- Inserting data into GENRE table
INSERT INTO GENRE (GENREName)
VALUES 
('Action'),
('Adventure'),
('Puzzle'),
('RPG'),
('Strategy'),
('Simulation'),
('Sports'),
('Horror'),
('Fighting'),
('Platformer'),
('Racing'),
('Survival'),
('MMO'),
('Music'),
('Educational'),
('Arcade'),
('Card'),
('Shooter'),
('Trivia'),
('Board');

-- Inserting data into PRODUCT_GENRE table
INSERT INTO PRODUCT_GENRE (PRODUCTId, GENREName)
VALUES 
(1, 'Platformer'),
(2, 'Action'),
(2, 'Adventure'),
(3, 'Arcade'),
(4, 'Arcade'),
(4, 'Puzzle'),
(5, 'Action'),
(5, 'Adventure'),
(6, 'Platformer'),
(7, 'Platformer'),
(8, 'Arcade'),
(8, 'Action'),
(8, 'Platformer'),
(9, 'Fighting'),
(10, 'RPG'),
(11, 'RPG'),
(12, 'Survival'),
(12, 'Educational'),
(12, 'Simulation'),
(13, 'Arcade'),
(14, 'Action'),
(14, 'Platformer'),
(15, 'Action'),
(15, 'Shooter'),
(16, 'Action'),
(16, 'Shooter'),
(17, 'RPG'),
(18, 'Racing'),
(19, 'Simulation'),
(20, 'Strategy');

-- Inserting data into WISHLIST table
INSERT INTO WISHLIST (PRODUCTId, UserName)
VALUES 
(1, 'johnDoe'),
(2, 'johnDoe'),
(3, 'janeDoe'),
(4, 'bobSmith'),
(5, 'emilyJones'),
(6, 'emilyJones'),
(7, 'saraWilson'),
(8, 'saraWilson'),
(9, 'chrisTaylor'),
(10, 'lisaJohnson'),
(11, 'steveWilson'),
(12, 'maryClark'),
(13, 'maryClark'),
(14, 'ryanMiller'),
(15, 'ryanMiller'),
(16, 'amyLee'),
(17, 'amyLee'),
(18, 'aliceSmith'),
(19, 'aliceSmith'),
(20, 'mikeBrown');

-- Inserting data into SHOPPINGCART table
INSERT INTO SHOPPINGCART (PRODUCTId, UserName)
VALUES 
(1, 'johnDoe'),
(2, 'johnDoe'),
(3, 'janeDoe'),
(4, 'bobSmith'),
(5, 'emilyJones'),
(6, 'emilyJones'),
(7, 'saraWilson'),
(8, 'saraWilson'),
(9, 'chrisTaylor'),
(10, 'lisaJohnson'),
(11, 'steveWilson'),
(12, 'maryClark'),
(13, 'maryClark'),
(14, 'ryanMiller'),
(15, 'ryanMiller'),
(16, 'amyLee'),
(17, 'amyLee'),
(18, 'aliceSmith'),
(19, 'aliceSmith'),
(20, 'mikeBrown');

-- Inserting data into IMAGES table
INSERT INTO IMAGES (IMAGESId, LINK)
VALUES 
(1, 'Data/images/super_mario_bros.jpg'),
(2, 'Data/images/the_legends_of_zelda.png'),
(3, 'Data/images/pac-man.png'),
(4, 'Data/images/tetris.png'),
(5, 'Data/images/super_metroid.jpg'),
(6, 'Data/images/mega_man_2.jpg'),
(7, 'Data/images/sonic.jpg'),
(8, 'Data/images/donkey_kong.jpg'),
(9, 'Data/images/street_fighter_2.jpg'),
(10, 'Data/images/final_fantasy.png'),
(11, 'Data/images/chrono-trigger.jpg'),
(12, 'Data/images/the_oregon_trail.jpg'),
(13, 'Data/images/space_invaders.jpg'),
(14, 'Data/images/castlevania.jpg'),
(15, 'Data/images/DOOM.jpg'),
(16, 'Data/images/gloden_eye_oo7.png'),
(17, 'Data/images/pokemon.jpg'),
(18, 'Data/images/Mario_Kart_Wii.png'),
(19, 'Data/images/SimCity_2000.png'),
(20, 'Data/images/civilization_II.jpg');
-- Inserting data into PRODUCT_IMAGE table
INSERT INTO PRODUCT_IMAGE (IMAGESId, PRODUCTId)
VALUES 
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20);
