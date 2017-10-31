/* PRIMARY KEY ensures that the id of the movie is unique to each movie 
   CHECK ensures that the id of the movie is non-negative */
CREATE TABLE Movie(id INT PRIMARY KEY, title VARCHAR(100), year INT, rating VARCHAR(10), company VARCHAR(50), CHECK(id >= 0)) ENGINE=INNODB;
/* PRIMARY KEY ensures id of the actor is unique to each person */
CREATE TABLE Actor(id INT PRIMARY KEY, last VARCHAR(20), first VARCHAR(20), sex VARCHAR(6), dob DATE, dod DATE) ENGINE=INNODB;
/* CHECK ensures that the ticketsSold is a non-negative number */
CREATE TABLE Sales(mid INT, ticketsSold INT, totalIncome INT, CHECK(ticketsSold >= 0)) ENGINE=INNODB;
/* PRIMARY KEY ensures the id of Director is unique to each director */
CREATE TABLE Director(id INT PRIMARY KEY, last VARCHAR(20), first VARCHAR(20), dob DATE, dod DATE) ENGINE=INNODB;
/* FOREIGN KEY ensures that the movie refered in MovieGenre exists in Movie */
CREATE TABLE MovieGenre(mid INT, genre VARCHAR(20), FOREIGN KEY (mid) references Movie(id)) ENGINE=INNODB;
/* FOREIGN KEY ensures that the movie, and the director refered in MovieDirector exists in Movie and Director */
CREATE TABLE MovieDirector(mid INT, did INT, FOREIGN KEY (mid) references Movie(id), FOREIGN KEY (did) references Director(id)) ENGINE=INNODB;
/* FOREIGN KEY ensures that the movie, and the actor refered in MovieDirector exists in Movie and Director */
CREATE TABLE MovieActor(mid INT, aid INT, role VARCHAR(50), FOREIGN KEY (mid) references Movie (id), FOREIGN KEY (aid) references Actor (id)) ENGINE=INNODB;
/* FOREIGN KEY ensures that the movie refered in MovieRating exists in Movie 
   CHECK ensures that the ratings are scaled to 0-100*/
CREATE TABLE MovieRating(mid INT, imdb INT, rot INT, FOREIGN KEY (mid) references Movie(id), CHECK(imdb >= 0 AND imdb <= 100 AND rot >= 0 AND rot <= 100)) ENGINE=INNODB;
CREATE TABLE Review(name VARCHAR(20), time TIMESTAMP, mid INT, rating INT, comment VARCHAR(500)) ENGINE=INNODB;
CREATE TABLE MaxPersonID(id INT) ENGINE=INNODB;
CREATE TABLE MaxMovieID(id INT) ENGINE=INNODB;
