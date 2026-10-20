--
-- PostgreSQL database dump
--

\restrict dfu3BW2GyrgnaEwxQsuZimEdPhxiSiA3KoAYztWMEf9TQ4gI93OPRFDRlUwcH6K

-- Dumped from database version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)

-- Started on 2026-10-20 16:31:26 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 222 (class 1259 OID 41063)
-- Name: cotacao; Type: TABLE; Schema: public; Owner: fernantravels
--

CREATE TABLE public.cotacao (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    telefone character varying(20) NOT NULL,
    email character varying(100) NOT NULL,
    origem character varying(100) NOT NULL,
    destino character varying(100) NOT NULL,
    ida date NOT NULL,
    volta date NOT NULL,
    qnt_adultos integer NOT NULL,
    qnt_criancas integer NOT NULL,
    qnt_bagagens integer NOT NULL,
    hotel character varying(50) NOT NULL,
    carro character varying(50) NOT NULL,
    id_cliente integer
);


ALTER TABLE public.cotacao OWNER TO fernantravels;

--
-- TOC entry 221 (class 1259 OID 41062)
-- Name: cotacao_id_seq; Type: SEQUENCE; Schema: public; Owner: fernantravels
--

CREATE SEQUENCE public.cotacao_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cotacao_id_seq OWNER TO fernantravels;

--
-- TOC entry 3497 (class 0 OID 0)
-- Dependencies: 221
-- Name: cotacao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: fernantravels
--

ALTER SEQUENCE public.cotacao_id_seq OWNED BY public.cotacao.id;


--
-- TOC entry 220 (class 1259 OID 41046)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: fernantravels
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(150) NOT NULL,
    email character varying(150) NOT NULL,
    senha character varying(255) NOT NULL,
    perfil character varying(20) DEFAULT 'cliente'::character varying NOT NULL
);


ALTER TABLE public.usuarios OWNER TO fernantravels;

--
-- TOC entry 219 (class 1259 OID 41045)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: fernantravels
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO fernantravels;

--
-- TOC entry 3498 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: fernantravels
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 3331 (class 2604 OID 41066)
-- Name: cotacao id; Type: DEFAULT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.cotacao ALTER COLUMN id SET DEFAULT nextval('public.cotacao_id_seq'::regclass);


--
-- TOC entry 3329 (class 2604 OID 41049)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 3491 (class 0 OID 41063)
-- Dependencies: 222
-- Data for Name: cotacao; Type: TABLE DATA; Schema: public; Owner: fernantravels
--

COPY public.cotacao (id, nome, telefone, email, origem, destino, ida, volta, qnt_adultos, qnt_criancas, qnt_bagagens, hotel, carro, id_cliente) FROM stdin;
3	gabi	19999999999	gabi@gmail.com	Americana	Italia	2026-10-21	2026-10-29	1	0	1	sim	sim	4
4	Gabriel	19999999999	gabriel@gmail.com	Americana	Australia	2026-10-20	2026-10-29	3	2	5	sim	nao	3
5	Cataria	19999999999	cat@cat.com	Americana	Cancun	2026-10-21	2026-11-04	2	0	2	sim	sim	1
2	Gabriell	19999999999	gabriel@gmail.com	Americana	Alemanha	2026-10-22	2026-10-28	1	0	0	sim	sim	1
\.


--
-- TOC entry 3489 (class 0 OID 41046)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: fernantravels
--

COPY public.usuarios (id, nome, email, senha, perfil) FROM stdin;
1	admin	admin@admin.com	$2y$12$z0IgsZ9rEDDWzfyRRSbzSOlhxVSWjVkW1vHg14RSETP7vv.fAvgKq	admin
3	Gabriel Fernandes	gabriel@gmail.com	$2y$12$DhGnQmowJVfRQP7SIvR1OuzmuhMDGeFntyzrj9bOX7lhBMTllcTlG	cliente
4	Gabi	gabi@gmail.com	$2y$12$904zMrGFmBzmLE/CcyopNePNCUs1fES6kIRaWC6FV1va4fUcJ2/12	cliente
\.


--
-- TOC entry 3499 (class 0 OID 0)
-- Dependencies: 221
-- Name: cotacao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: fernantravels
--

SELECT pg_catalog.setval('public.cotacao_id_seq', 5, true);


--
-- TOC entry 3500 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: fernantravels
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 4, true);


--
-- TOC entry 3339 (class 2606 OID 41083)
-- Name: cotacao cotacao_pkey; Type: CONSTRAINT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.cotacao
    ADD CONSTRAINT cotacao_pkey PRIMARY KEY (id);


--
-- TOC entry 3333 (class 2606 OID 41061)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 3335 (class 2606 OID 41059)
-- Name: usuarios usuarios_nome_key; Type: CONSTRAINT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_nome_key UNIQUE (nome);


--
-- TOC entry 3337 (class 2606 OID 41057)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 3340 (class 2606 OID 41084)
-- Name: cotacao cotacao_id_cliente_fkey; Type: FK CONSTRAINT; Schema: public; Owner: fernantravels
--

ALTER TABLE ONLY public.cotacao
    ADD CONSTRAINT cotacao_id_cliente_fkey FOREIGN KEY (id_cliente) REFERENCES public.usuarios(id);


-- Completed on 2026-10-20 16:31:30 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict dfu3BW2GyrgnaEwxQsuZimEdPhxiSiA3KoAYztWMEf9TQ4gI93OPRFDRlUwcH6K

