CREATE TABLE IF NOT EXISTS public.cat_user
(
    id text COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default",
    name character varying(255) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default",
    status integer,
    CONSTRAINT cat_user_pkey PRIMARY KEY (id)
); -- This semicolon was missing

CREATE TABLE cat_materiaux (
    id INT PRIMARY KEY,
    nom VARCHAR(255),
    prix_kilo DECIMAL(10, 2)
); -- This semicolon was missing


INSERT INTO cat_materiaux (id, nom, prix_kilo) VALUES (1, 'Fer', 1.5);