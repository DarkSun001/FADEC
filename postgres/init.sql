-- Table: public.cat_user

-- DROP TABLE IF EXISTS public.cat_user;

CREATE TABLE IF NOT EXISTS public.cat_user
(
    id character(20) COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default",
    name character varying(255) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default",
    status integer,
    CONSTRAINT cat_user_pkey PRIMARY KEY (id)
)


CREATE TABLE cat_materiaux (
    id INT PRIMARY KEY,
    nom VARCHAR(255),
    prix_kilo DECIMAL(10, 2)
);

INSERT INTO cat_materiaux (id,nom, prix_kilo) VALUES
    (1,'Ciment', 0.05),    -- Prix en euros par kilo
    (2,'Sable', 0.02),
    (3,'Gravier', 0.03);




TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.cat_user
    OWNER to fadec_user;