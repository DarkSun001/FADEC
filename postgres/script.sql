-- Table: public.cat_user

-- DROP TABLE IF EXISTS public.cat_user;

CREATE TABLE IF NOT EXISTS public.cat_user
(
    id SERIAL PRIMARY KEY, 
    email character varying(255) COLLATE pg_catalog."default",
    name character varying(255) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default",
    status integer
);

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.cat_user
    OWNER to fadec_user;