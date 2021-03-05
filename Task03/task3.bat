#!/bin/bash
chcp 65001


sqlite3 movies_rating.db < db_init.sql
@ echo off


echo 1. Текст первого задания. Вывести список из 10 фильмов.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT DISTINCT title AS "Movie", year AS "Year" FROM movies INNER JOIN ratings ON movies.id = ratings.movie_id WHERE movies.year IS NOT NULL ORDER BY movies.year, movies.title ASC LIMIT 10"


echo 2. Вывести список из 5 пользователей.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT * FROM users WHERE instr(name,'A')>1 ORDER BY register_date ASC LIMIT 5"


echo 3. Информаци о рейтингах в более читаемом формате.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT name AS "Name", movies.title AS "Movie", movies.year AS "Year", ratings.rating AS "Rating", date(ratings.timestamp,'unixepoch') AS "Date" FROM ratings INNER JOIN movies ON movies.id = ratings.movie_id INNER JOIN users ON users.id = ratings.user_id ORDER BY users.name, movies.title, ratings.rating ASC LIMIT 50"


echo 4. Список фильмов с указанием тегов.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT title AS "Movie", year AS "Year", tags.tag AS "Tag" FROM movies INNER JOIN tags ON tags.movie_id = movies.id ORDER BY movies.year, movies.title, tags.tag ASC LIMIT 40"


echo 5. Список самых свежих фильмов.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT title AS "Movie", year AS "Year" FROM movies WHERE year = (SELECT MAX(year) FROM movies WHERE length(year)>0)"
pause