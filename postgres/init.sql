-- Table: public.cat_user

-- DROP TABLE IF EXISTS public.cat_user;

CREATE TABLE IF NOT EXISTS public.cat_user
(
    id text COLLATE pg_catalog."default" NOT NULL,
    email character varying(255) COLLATE pg_catalog."default",
    name character varying(255) COLLATE pg_catalog."default",
    password character varying(255) COLLATE pg_catalog."default",
    status integer,
    CONSTRAINT cat_user_pkey PRIMARY KEY (id)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.cat_user
    OWNER to fadec_user;