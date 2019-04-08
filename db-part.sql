/*
1. Я главный редактор‚ у меня есть список новостей. Мне нужно хранить заголовок новости и ее авторов. Предложите мне структуру таблиц.
Количество данных:
новости ~1 000 000
авторы ~3 000
среднее количество соавторов новостей ~1.8
СУБД PostgreSQL
*/
SELECT version();

CREATE SCHEMA just_click;
SET search_path TO just_click;
SHOW search_path;

CREATE TABLE article
      (
      id serial PRIMARY KEY,
      rating int
      )
;

CREATE TABLE author
(
    id serial PRIMARY KEY
);
CREATE TABLE article_author
(
    id serial PRIMARY KEY,
    article_id int,
    author_id int,
    CONSTRAINT article_author_article_id_fk FOREIGN KEY (article_id) REFERENCES article (id),
    CONSTRAINT article_author_athor_id_fk FOREIGN KEY (author_id) REFERENCES author (id)
);
COMMENT ON COLUMN just_click.article_author.article_id IS 'link to article';
COMMENT ON COLUMN just_click.article_author.author_id IS 'link to author of article';

/*
2. Вытащите список новостей‚ которые написаны 3-мя и более соавторами. То есть получить отчет «новость — количество соавторов» и отфильтровать те‚ у которых соавторов меньше 3.
*/
SET search_path TO just_click;
SHOW search_path;

select 
       ar.id AS 'новость',
        count(*) AS 'количество соавторов'
from 
    article ar
    join article_author aa
    on ar.id = aa.article_id
GROUP BY ar.id
HAVING count(*) >2;

/*
3. У каждой новости есть рейтинг. Нужно выбрать для каждого автора его лучшую и худшую новость.
*/
SET search_path TO just_click;
SHOW search_path;

/*
не уверен что этот индекс нужен, но без генерации данных не проверить
*/
CREATE INDEX article_rating_index ON article (rating);

select
  au.id AS 'автор'
  , max(ar.rating) AS 'лучшая'
  , min(ar.rating) AS 'худшая'
from
    author au
    join article_author aa
    on au.id = aa.author_id
    join article ar on
    aa.article_id = ar.id
GROUP BY au.id
order by au.id
