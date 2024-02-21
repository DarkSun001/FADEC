CREATE TABLE IF NOT EXISTS public.cat_user
(
    id text COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default",
    name character varying(255) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default",
    status integer,
    jwt_token text COLLATE pg_catalog."default",
    CONSTRAINT cat_user_pkey PRIMARY KEY (id)
); -- This semicolon was missing

CREATE TABLE cat_materiaux (
    id INT PRIMARY KEY,
    nom VARCHAR(255),
    prix_kilo DECIMAL(10, 2)
); -- This semicolon was missing

-- token
CREATE TABLE cat_token (
    id text COLLATE pg_catalog."default" NOT NULL,
    token character varying(255),
    user_id TEXT,
    created_at TIMESTAMP
); -- This semicolon was missing


INSERT INTO cat_materiaux (id, nom, prix_kilo) VALUES (1, 'Fer', 1.5);