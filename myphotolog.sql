--
-- PostgreSQL database dump
--

-- Dumped from database version 9.0.1
-- Dumped by pg_dump version 9.0.1
-- Started on 2011-07-24 16:23:49

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 325 (class 2612 OID 11574)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE OR REPLACE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1518 (class 1259 OID 16546)
-- Dependencies: 1808 5
-- Name: banned; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE banned (
    id integer NOT NULL,
    reason character varying(100) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.banned OWNER TO postgres;

--
-- TOC entry 1517 (class 1259 OID 16544)
-- Dependencies: 5 1518
-- Name: banned_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE banned_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.banned_id_seq OWNER TO postgres;

--
-- TOC entry 1851 (class 0 OID 0)
-- Dependencies: 1517
-- Name: banned_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE banned_id_seq OWNED BY banned.id;


--
-- TOC entry 1520 (class 1259 OID 16555)
-- Dependencies: 1810 5
-- Name: countries; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE countries (
    id integer NOT NULL,
    country character varying(75) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.countries OWNER TO postgres;

--
-- TOC entry 1519 (class 1259 OID 16553)
-- Dependencies: 1520 5
-- Name: countries_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE countries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.countries_id_seq OWNER TO postgres;

--
-- TOC entry 1852 (class 0 OID 0)
-- Dependencies: 1519
-- Name: countries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE countries_id_seq OWNED BY countries.id;


--
-- TOC entry 1522 (class 1259 OID 16564)
-- Dependencies: 1812 1813 5
-- Name: groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE groups (
    id integer NOT NULL,
    title character varying(20) DEFAULT ''::character varying NOT NULL,
    description character varying(100) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.groups OWNER TO postgres;

--
-- TOC entry 1521 (class 1259 OID 16562)
-- Dependencies: 1522 5
-- Name: groups_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_id_seq OWNER TO postgres;

--
-- TOC entry 1853 (class 0 OID 0)
-- Dependencies: 1521
-- Name: groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE groups_id_seq OWNED BY groups.id;


--
-- TOC entry 1529 (class 1259 OID 16611)
-- Dependencies: 5
-- Name: photos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE photos (
    id_photo integer NOT NULL,
    link character varying(255) NOT NULL,
    "order" integer,
    visible boolean
);


ALTER TABLE public.photos OWNER TO postgres;

--
-- TOC entry 1528 (class 1259 OID 16609)
-- Dependencies: 1529 5
-- Name: photos_id_photo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE photos_id_photo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.photos_id_photo_seq OWNER TO postgres;

--
-- TOC entry 1854 (class 0 OID 0)
-- Dependencies: 1528
-- Name: photos_id_photo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE photos_id_photo_seq OWNED BY photos.id_photo;


--
-- TOC entry 1524 (class 1259 OID 16574)
-- Dependencies: 1815 1816 5
-- Name: questions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE questions (
    id integer NOT NULL,
    question character varying(80) DEFAULT ''::character varying NOT NULL,
    answer character varying(40) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.questions OWNER TO postgres;

--
-- TOC entry 1523 (class 1259 OID 16572)
-- Dependencies: 5 1524
-- Name: questions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.questions_id_seq OWNER TO postgres;

--
-- TOC entry 1855 (class 0 OID 0)
-- Dependencies: 1523
-- Name: questions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE questions_id_seq OWNED BY questions.id;


--
-- TOC entry 1525 (class 1259 OID 16582)
-- Dependencies: 1817 1818 1819 5
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sessions (
    session_id character varying(40) DEFAULT ''::character varying NOT NULL,
    ip_address character varying(16) DEFAULT ''::character varying NOT NULL,
    user_agent character varying(50) NOT NULL,
    last_activity integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- TOC entry 1527 (class 1259 OID 16593)
-- Dependencies: 1821 1822 1823 1824 1825 1826 1827 1828 1829 1830 5
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    group_id integer DEFAULT 0 NOT NULL,
    banned_id integer DEFAULT 0 NOT NULL,
    country_id integer DEFAULT 0 NOT NULL,
    question_id integer DEFAULT 0 NOT NULL,
    username character varying(15) DEFAULT ''::character varying NOT NULL,
    password character varying(40) DEFAULT ''::character varying NOT NULL,
    email character varying(40) DEFAULT ''::character varying NOT NULL,
    hash character varying(40) DEFAULT ''::character varying NOT NULL,
    activation_code character varying(40) DEFAULT ''::character varying NOT NULL,
    forgotten_password_code character varying(40) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 1526 (class 1259 OID 16591)
-- Dependencies: 5 1527
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 1856 (class 0 OID 0)
-- Dependencies: 1526
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- TOC entry 1807 (class 2604 OID 16549)
-- Dependencies: 1517 1518 1518
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE banned ALTER COLUMN id SET DEFAULT nextval('banned_id_seq'::regclass);


--
-- TOC entry 1809 (class 2604 OID 16558)
-- Dependencies: 1520 1519 1520
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE countries ALTER COLUMN id SET DEFAULT nextval('countries_id_seq'::regclass);


--
-- TOC entry 1811 (class 2604 OID 16567)
-- Dependencies: 1521 1522 1522
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE groups ALTER COLUMN id SET DEFAULT nextval('groups_id_seq'::regclass);


--
-- TOC entry 1831 (class 2604 OID 16614)
-- Dependencies: 1529 1528 1529
-- Name: id_photo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE photos ALTER COLUMN id_photo SET DEFAULT nextval('photos_id_photo_seq'::regclass);


--
-- TOC entry 1814 (class 2604 OID 16577)
-- Dependencies: 1523 1524 1524
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE questions ALTER COLUMN id SET DEFAULT nextval('questions_id_seq'::regclass);


--
-- TOC entry 1820 (class 2604 OID 16596)
-- Dependencies: 1526 1527 1527
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- TOC entry 1833 (class 2606 OID 16552)
-- Dependencies: 1518 1518
-- Name: banned_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY banned
    ADD CONSTRAINT banned_pkey PRIMARY KEY (id);


--
-- TOC entry 1835 (class 2606 OID 16561)
-- Dependencies: 1520 1520
-- Name: countries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY countries
    ADD CONSTRAINT countries_pkey PRIMARY KEY (id);


--
-- TOC entry 1837 (class 2606 OID 16571)
-- Dependencies: 1522 1522
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (id);


--
-- TOC entry 1845 (class 2606 OID 16616)
-- Dependencies: 1529 1529
-- Name: id_photo; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY photos
    ADD CONSTRAINT id_photo PRIMARY KEY (id_photo);


--
-- TOC entry 1839 (class 2606 OID 16581)
-- Dependencies: 1524 1524
-- Name: questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);


--
-- TOC entry 1841 (class 2606 OID 16589)
-- Dependencies: 1525 1525
-- Name: sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (session_id);


--
-- TOC entry 1843 (class 2606 OID 16608)
-- Dependencies: 1527 1527
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 1850 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2011-07-24 16:23:50

--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 9.0.1
-- Dumped by pg_dump version 9.0.1
-- Started on 2011-07-24 16:24:24

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 1855 (class 0 OID 0)
-- Dependencies: 1517
-- Name: banned_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('banned_id_seq', 1, false);


--
-- TOC entry 1856 (class 0 OID 0)
-- Dependencies: 1519
-- Name: countries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('countries_id_seq', 1, false);


--
-- TOC entry 1857 (class 0 OID 0)
-- Dependencies: 1521
-- Name: groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('groups_id_seq', 1, false);


--
-- TOC entry 1858 (class 0 OID 0)
-- Dependencies: 1528
-- Name: photos_id_photo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('photos_id_photo_seq', 181, true);


--
-- TOC entry 1859 (class 0 OID 0)
-- Dependencies: 1523
-- Name: questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('questions_id_seq', 4, true);


--
-- TOC entry 1860 (class 0 OID 0)
-- Dependencies: 1526
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 4, true);


--
-- TOC entry 1846 (class 0 OID 16546)
-- Dependencies: 1518
-- Data for Name: banned; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY banned (id, reason) FROM stdin;
\.


--
-- TOC entry 1847 (class 0 OID 16555)
-- Dependencies: 1520
-- Data for Name: countries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY countries (id, country) FROM stdin;
1	United States
2	Canada
3	Mexico
4	Afghanistan
5	Albania
6	Algeria
7	Andorra
8	Angola
9	Anguilla
10	Antarctica
11	Antigua and Barbuda
12	Argentina
13	Armenia
14	Aruba
15	Ascension Island
16	Australia
17	Austria
18	Azerbaijan
19	Bahamas
20	Bahrain
21	Bangladesh
22	Barbados
23	Belarus
24	Belgium
25	Belize
26	Benin
27	Bermuda
28	Bhutan
29	Bolivia
30	Bophuthatswana
31	Bosnia-Herzegovina
32	Botswana
33	Bouvet Island
34	Brazil
35	British Indian Ocean
36	British Virgin Islands
37	Brunei Darussalam
38	Bulgaria
39	Burkina Faso
40	Burundi
41	Cambodia
42	Cameroon
44	Cape Verde Island
45	Cayman Islands
46	Central Africa
47	Chad
48	Channel Islands
49	Chile
50	China, Peoples Republic
51	Christmas Island
52	Cocos (Keeling) Islands
53	Colombia
54	Comoros Islands
55	Congo
56	Cook Islands
57	Costa Rica
58	Croatia
59	Cuba
60	Cyprus
61	Czech Republic
62	Denmark
63	Djibouti
64	Dominica
65	Dominican Republic
66	Easter Island
67	Ecuador
68	Egypt
69	El Salvador
70	England
71	Equatorial Guinea
72	Estonia
73	Ethiopia
74	Falkland Islands
75	Faeroe Islands
76	Fiji
77	Finland
78	France
79	French Guyana
80	French Polynesia
81	Gabon
82	Gambia
83	Georgia Republic
84	Germany
85	Gibraltar
86	Greece
87	Greenland
88	Grenada
89	Guadeloupe (French)
90	Guatemala
91	Guernsey Island
92	Guinea Bissau
93	Guinea
94	Guyana
95	Haiti
96	Heard and McDonald Isls
97	Honduras
98	Hong Kong
99	Hungary
100	Iceland
101	India
102	Iran
103	Iraq
104	Ireland
105	Isle of Man
106	Israel
107	Italy
108	Ivory Coast
109	Jamaica
110	Japan
111	Jersey Island
112	Jordan
113	Kazakhstan
114	Kenya
115	Kiribati
116	Kuwait
117	Laos
118	Latvia
119	Lebanon
120	Lesotho
121	Liberia
122	Libya
123	Liechtenstein
124	Lithuania
125	Luxembourg
126	Macao
127	Macedonia
128	Madagascar
129	Malawi
130	Malaysia
131	Maldives
132	Mali
133	Malta
134	Martinique (French)
135	Mauritania
136	Mauritius
137	Mayotte
139	Micronesia
140	Moldavia
141	Monaco
142	Mongolia
143	Montenegro
144	Montserrat
145	Morocco
146	Mozambique
147	Myanmar
148	Namibia
149	Nauru
150	Nepal
151	Netherlands Antilles
152	Netherlands
153	New Caledonia (French)
154	New Zealand
155	Nicaragua
156	Niger
157	Niue
158	Norfolk Island
159	North Korea
160	Northern Ireland
161	Norway
162	Oman
163	Pakistan
164	Panama
165	Papua New Guinea
166	Paraguay
167	Peru
168	Philippines
169	Pitcairn Island
170	Poland
171	Polynesia (French)
172	Portugal
173	Qatar
174	Reunion Island
175	Romania
176	Russia
177	Rwanda
178	S.Georgia Sandwich Isls
179	Sao Tome, Principe
180	San Marino
181	Saudi Arabia
182	Scotland
183	Senegal
184	Serbia
185	Seychelles
186	Shetland
187	Sierra Leone
188	Singapore
189	Slovak Republic
190	Slovenia
191	Solomon Islands
192	Somalia
193	South Africa
194	South Korea
195	Spain
196	Sri Lanka
197	St. Helena
198	St. Lucia
199	St. Pierre Miquelon
200	St. Martins
201	St. Kitts Nevis Anguilla
202	St. Vincent Grenadines
203	Sudan
204	Suriname
205	Svalbard Jan Mayen
206	Swaziland
207	Sweden
208	Switzerland
209	Syria
210	Tajikistan
211	Taiwan
212	Tahiti
213	Tanzania
214	Thailand
215	Togo
216	Tokelau
217	Tonga
218	Trinidad and Tobago
219	Tunisia
220	Turkmenistan
221	Turks and Caicos Isls
222	Tuvalu
223	Uganda
224	Ukraine
225	United Arab Emirates
226	Uruguay
227	Uzbekistan
228	Vanuatu
229	Vatican City State
230	Venezuela
231	Vietnam
232	Virgin Islands (Brit)
233	Wales
234	Wallis Futuna Islands
235	Western Sahara
236	Western Samoa
237	Yemen
238	Yugoslavia
239	Zaire
240	Zambia
241	Zimbabwe
\.


--
-- TOC entry 1848 (class 0 OID 16564)
-- Dependencies: 1522
-- Data for Name: groups; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY groups (id, title, description) FROM stdin;
\.


--
-- TOC entry 1852 (class 0 OID 16611)
-- Dependencies: 1529
-- Data for Name: photos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY photos (id_photo, link, "order", visible) FROM stdin;
13	http://imgs.abduzeedo.com/files/misc/rss_24.png\r	7438	f
14	http://imgs.abduzeedo.com/files/misc/tw_24.png\r	7484	f
3	http://leganerd.com/wp-content/uploads/2010/07/table-mountain111.jpg\r	6167	t
1	http://www.falsodautoregiulioromano.it/falsi_d%27autore_g_i00007c.jpg\r	3956	f
4	http://www.geometriefluide.com/foto/PIC3098O.jpg\r	503	t
2	http://www.geometriefluide.com/foto/PIC3098O.jpg\r	2125	f
6	http://sorgenia.files.wordpress.com/2011/04/sorgenia_londra_tower_bridge.jpg\r	8471	f
5	http://www.radiospin.poloprato.unifi.it/prato/wp-content/uploads/2011/02/QueenLogo.jpg	1855	t
7	http://www.good2know.it/wp-content/uploads/2010/12/ZendFramework-logo-2.png\r	6066	t
9	http://www.good2know.it/wp-content/uploads/2011/05/facebook-hiphop.jpg\r	1778	t
10	http://www.good2know.it/wp-content/uploads/2011/04/special_gadgets.jpg\r	9752	t
11	http://www.good2know.it/wp-content/uploads/2011/04/gopano-micro.jpg	2505	t
8	http://www.good2know.it/wp-content/uploads/2010/12/ZendFramework-logo-2-150x150.png\r	4301	f
12	http://abduzeedo.com/files/imagecache/img690x320/originals/wp_1024-161.jpg	3535	t
16	http://abduzeedo.com/files/imagecache/img690x320/originals/bow181.jpg\r	7840	t
19	http://imgs.abduzeedo.com/files/best_week/trey_ratcliff_150.jpg\r	4538	t
21	http://imgs.abduzeedo.com/files/best_week/Screen-shot-2011-07-22-at-53557-PM.png\r	4994	t
22	http://imgs.abduzeedo.com/files/best_week/socialtravelinfo.png\r	2354	t
23	http://imgs.abduzeedo.com/files/best_week/Used_Cubicles_Workstations-520x245.jpg\r	7555	t
24	http://imgs.abduzeedo.com/files/best_week/mobile_info_ads.png\r	8003	t
25	http://imgs.abduzeedo.com/files/best_week/i-had-cancer-screen.jpg\r	8587	t
27	http://imgs.abduzeedo.com/files/best_week/tumblr_lojk9d6kIe1qf44feo1_500.jpg\r	6645	t
28	http://imgs.abduzeedo.com/files/best_week/unnamed_qjpz9i7mmy.jpg\r	9501	t
29	http://imgs.abduzeedo.com/files/best_week/responsive-design-116.jpg\r	9973	t
30	http://imgs.abduzeedo.com/files/best_week/santaceia_01.jpg\r	6209	t
34	http://imgs.abduzeedo.com/files/best_week/1311200511-3ready-439x500.jpg\r	8225	t
36	http://imgs.abduzeedo.com/files/best_week/citroen_concept5.jpg\r	7516	t
37	http://imgs.abduzeedo.com/files/best_week/c_vszmawo8qa.jpg\r	9873	t
38	http://imgs.abduzeedo.com/files/best_week/unnamed_berkf007nb.jpg\r	6549	t
39	http://imgs.abduzeedo.com/files/best_week/unnamed_18dlqf9o50.jpg\r	7237	t
40	http://imgs.abduzeedo.com/files/best_week/CA_image4.jpg\r	5908	t
42	http://imgs.abduzeedo.com/files/best_week/songsandalbuns_work.png\r	7119	t
46	http://imgs.abduzeedo.com/files/best_week/Flud-for-iPad-520x245.jpg\r	872	t
47	http://imgs.abduzeedo.com/files/best_week/whatsnew_missioncontrol_screen-520x325.jpg\r	4774	t
50	http://imgs.abduzeedo.com/files/best_week/tumblr_lojguxf8VF1qzrula.jpg\r	3747	t
51	http://imgs.abduzeedo.com/files/best_week/beastieboys.jpg\r	1247	t
52	http://imgs.abduzeedo.com/files/best_week/unnamed_z8xkfb3gl6.jpg\r	4874	t
53	http://imgs.abduzeedo.com/files/best_week/DYT-skateboard-musique-classique-1.jpg\r	4438	t
54	http://imgs.abduzeedo.com/files/best_week/photo1101.jpg\r	6680	t
55	http://imgs.abduzeedo.com/files/best_week/014_McLean_Quinlan_4742254446_431a7ed979_o.jpg\r	4107	t
56	http://imgs.abduzeedo.com/files/best_week/5833262551_c4bb949eb8_b.jpg\r	7251	t
58	http://imgs.abduzeedo.com/files/best_week/c_jdhh15sta9.jpg\r	5610	t
59	http://imgs.abduzeedo.com/files/best_week/icons_textures12.jpg\r	541	t
60	http://imgs.abduzeedo.com/files/best_week/i_snsticker5.jpg\r	9218	t
61	http://imgs.abduzeedo.com/files/best_week/20110714-xby9uba62xp23brnnr39jdrj9q.png\r	4103	t
62	http://imgs.abduzeedo.com/files/best_week/mobileflickr.gif\r	1472	t
63	http://abduzeedo.com/files/imagecache/img210x170/originals/wp_1024-161.jpg\r	2738	t
64	http://abduzeedo.com/files/imagecache/img210x170/originals/bow181.jpg\r	9212	t
65	http://abduzeedo.com/files/imagecache/img210x170/originals/sow881.jpg\r	1562	t
15	http://imgs.abduzeedo.com/files/misc/fb_24.png\r	408	f
17	http://imgs.abduzeedo.com/files/best_week/abdz_credit-card-icons.jpg\r	4507	f
18	http://imgs.abduzeedo.com/files/best_week/chromebook-apps.jpg\r	3639	f
20	http://imgs.abduzeedo.com/files/best_week/htc-status-main-pic-1311320166.jpg\r	8595	f
41	http://imgs.abduzeedo.com/files/best_week/evernoteapp.jpg\r	2761	f
26	http://imgs.abduzeedo.com/files/best_week/apistaticmaps.jpg\r	9565	f
31	http://imgs.abduzeedo.com/files/best_week/\r	3997	f
33	http://imgs.abduzeedo.com/files/best_week/No-Internet-Thursday-520x245.jpg\r	8839	f
32	http://imgs.abduzeedo.com/files/best_week/gadget-520x245.jpg\r	1526	f
35	http://imgs.abduzeedo.com/files/best_week/headphonesinus3.jpg\r	6799	f
43	http://imgs.abduzeedo.com/files/best_week/hp_iltasks-thumb-470x294-31678.jpg\r	2499	f
44	http://imgs.abduzeedo.com/files/best_week/webputty_screenshot_0711.png\r	140	f
45	http://imgs.abduzeedo.com/files/best_week/newmacbookaair88.jpg\r	2194	f
57	http://imgs.abduzeedo.com/files/best_week/2011-07-18_1505-520x390.png\r	1624	f
48	http://imgs.abduzeedo.com/files/best_week/eric_dsc0067.jpg\r	8650	f
49	http://imgs.abduzeedo.com/files/best_week/1311017567-miisc-10-ad-528x351.jpg\r	7857	f
67	http://abduzeedo.com/files/imagecache/img210x170/originals/capacasad10.jpg\r	7883	t
68	http://abduzeedo.com/files/imagecache/img210x170/originals/110cover.jpg\r	670	t
69	http://abduzeedo.com/files/imagecache/img640x220/originals/quicktips_aoirostudio_mainpic.jpg\r	8691	t
71	http://imgs.abduzeedo.com/files/misc/mt-banner.jpg\r	8165	t
72	http://i.creativecommons.org/l/by-nc-sa/3.0/us/88x31.png	2031	f
66	http://abduzeedo.com/files/imagecache/img210x170/originals/ufeedmeback-teaser_0.jpg\r	206	f
70	http://imgs.abduzeedo.com/files/misc/abdz-book-banner.jpg\r	2749	f
74	http://img3.imageshack.us/img3/6716/amazingspidermanposter0.jpg\r	9679	t
75	http://img21.imageshack.us/img21/7682/9ae4aea3fb00ac9cd316b2a.jpg\r	5895	t
76	http://designyoutrust.com/wp-content/uploads/2011/07/unnamed_yn33ogzv74.jpg\r	7046	t
77	http://img715.imageshack.us/img715/9271/15unledlivingroom21.jpg \r	4270	t
78	http://www.pikted.com/wp-content/uploads/2011/07/Dmitry-Ligay-full.jpg\r	9077	t
79	http://www.pikted.com/wp-content/uploads/2011/07/NRG.jpg\r	3422	t
80	http://www.pikted.com/wp-content/uploads/2011/07/animal-full.jpg\r	8232	t
81	http://www.pikted.com/wp-content/uploads/2011/07/KDU-Solstice-by-Mike-Harrison..jpg\r	1593	t
86	http://duckflash.vectroave.netdna-cdn.com/wp-content/uploads/2011/07/Victoria-Lobach-Photography-6-600x899.jpg\r	7111	t
87	http://duckflash.vectroave.netdna-cdn.com/wp-content/uploads/2011/07/Victoria-Lobach-Photography-9-600x396.jpg\r	5451	t
88	http://duckflash.vectroave.netdna-cdn.com/wp-content/uploads/2011/07/ONEQ-Illustrations-4.jpg\r	621	t
89	http://duckflash.vectroave.netdna-cdn.com/wp-content/uploads/2011/07/ONEQ-Illustrations-8.jpg\r	8369	t
90	http://ego-alterego.com/wp-content/uploads/2011/07/117.jpg\r	2622	t
91	http://ego-alterego.com/wp-content/uploads/2011/07/116.jpg\r	9328	t
94	http://blog.wanken.com/wp-content/uploads/2011/07/greenrest5-on-wanken-shelby-white-530x706.jpg\r	5380	t
95	http://designspiration.net/data/assets/012011-042810PM_firefox_7.png\r	3027	t
96	http://designspiration.net/data/assets/032211-103509PM_e773d6e981fcd57e9342247110c6f58fe03461ba_m.jpg\r	7621	t
97	http://designspiration.net/data/assets/011811-053528PM_experimental_jetset_vb62.jpg\r	7565	t
98	http://www.emptykingdom.com/main/wp-content/uploads/2011/07/Amanda-Elizabeth-Joseph_web10.jpg\r	6322	t
99	http://farm4.static.flickr.com/3022/5864597430_c57fa5e34a_b.jpg\r	8739	t
100	http://www.emptykingdom.com/main/wp-content/uploads/2011/07/11_zing.jpg\r	817	t
101	http://farm3.static.flickr.com/2734/4362494784_4f8e33848d_o.jpg\r	4165	t
102	http://a3.sphotos.ak.fbcdn.net/hphotos-ak-snc4/67402_157760030930730_157747010932032_276140_6114818_n.jpg\r	1383	t
103	http://a7.sphotos.ak.fbcdn.net/hphotos-ak-snc4/69856_157760700930663_157747010932032_276142_6764400_n.jpg\r	3649	t
104	http://coolvibe.com/wp-content/uploads/2011/07/Pandemia-992x793.jpg\r	6730	t
105	http://coolvibe.com/wp-content/uploads/2011/07/game-project-09-992x1213.jpg\r	6684	t
106	http://www.cuded.com/wp-content/uploads/2011/03/20110331_screen_shot_2010_11_18_at_30729_pm-600x851.png\r	1504	t
107	http://www.cuded.com/wp-content/uploads/2011/03/20110331_minerva_stigmata_by_medusa_thedollmaker_d3ao2o1-600x844.jpg\r	9948	t
108	http://www.cuded.com/wp-content/uploads/2011/04/20110403_karolina_anderson.jpg\r	3794	t
109	http://www.cuded.com/wp-content/uploads/2011/04/eminem_by_benheined3bp7pk600_758.jpg\r	4807	t
110	http://shadowness.com/file/item4/102724/image_t6.jpg\r	2621	t
111	http://shadowness.com/file/item4/102365/image_t6.jpg\r	4819	t
112	http://shadowness.com/file/item4/104959/image_t6.jpg\r	5448	t
113	http://shadowness.com/file/item4/105127/image_t6.jpg\r	3224	t
114	http://api.ning.com/files/zKvBiHwK-*qsVzOP4Pn*1oWVvdb0HjDnxNpXjD9c7YyVG8OTqkXczkysvPLQ*vwi0paqJb5wj99yu53tnAb3VQlk9gBsas2k/KenJeongPhotobombsKateUptonGQ1.jpg\r	5672	t
115	http://api.ning.com/files/bCG6sjQLTvg*n2qkLw5BQ0r6EjaRDQUI1sjSBU4i*s6rMkOJPZnK0euuCjbrOg0UEr*0qMzw-9wLYcetUp2JaUgzNvK2lSks/RonvanderEnde6.jpg\r	452	t
116	http://api.ning.com/files/8K0ot86H1pnjhNIF-AT3Ed2PE0xN13aCxKLTimUBuDPmBi6ZKptOp8BoccQADMc5Uj6yDbWG6bhiFU5TjKKNSBlUbPpOypAJ/oakoak1.jpg\r	129	t
117	http://api.ning.com/files/9zHlTUWDgoeL4AdsnLVKLHKaDb2D*m0UhA9Sa*tuH9o2MPMPyL6db8*wAHveNKW4e04kd*ORI-6BJlkIuCFgv0jIxwgJYZ*G/AiShinohara8.jpg\r	1621	t
118	http://fc07.deviantart.net/fs70/f/2011/203/3/a/paradise_by_kkart-d41a748.png\r	6594	t
119	http://fc04.deviantart.net/fs71/i/2011/203/a/4/dawn_by_culpeo_fox-d41ad65.jpg\r	4035	t
120	http://th04.deviantart.net/fs70/PRE/i/2011/024/5/3/glitter_bokeh_by_falloutgirl9001-d37yabs.jpg\r	1275	t
121	http://cdnimg.visualizeus.com/thumbs/77/6d/animation,lady,,,smoke,women,art,inspiration,digital,art-776def8ab6577f4ff7ecb83eb458326d_h.jpg\r	4687	t
122	http://fantasyinspiration.com/wp-content/uploads/2011/07/wallpaper-5-2.jpg\r	6324	t
123	http://fantasyinspiration.com/wp-content/uploads/2011/07/wallpaper-5-6.jpg\r	7755	t
124	http://fantasyinspiration.com/wp-content/uploads/2011/07/wallpaper-5-12.jpg\r	7324	t
125	http://fantasyinspiration.com/wp-content/uploads/2011/07/wallpaper-5-14.jpg\r	2107	t
126	http://www.laurentnivalle.fr/images/garage/LMC2010/IMG_3484.jpg\r	800	t
82	http://www.flickr.com/photos/65533169@N06/5963025987/in/photostream/lightbox/\r	2908	f
83	http://www.flickr.com/photos/65533169@N06/5963026167/in/photostream/lightbox/\r	4212	f
84	http://www.flickr.com/photos/65533169@N06/5963027551/in/photostream\r	4944	f
85	http://www.flickr.com/photos/65533169@N06/5963584556/in/photostream\r	1396	f
92	http://ego-alterego.com/wp-content/uploads/2011/07/mercedes-logo-1902.jpg\r	3701	f
93	http://ego-alterego.com/wp-content/uploads/2011/07/benz-logo-1909.jpg\r	2195	f
73	http://abduzeedo.com/files/imagecache/img690x320/originals/sow881.jpg\r	9741	f
127	http://www.laurentnivalle.fr/images/garage/LMC2010/IMG_3461.jpg\r	8799	t
128	http://www.laurentnivalle.fr/images/garage/LMC2010/IMG_4406.jpg\r	1712	t
129	http://farm5.static.flickr.com/4041/4250902541_a06b109b22_z.jpg\r	8571	t
130	http://fc05.deviantart.net/fs70/f/2011/191/c/5/i_don__t_feel_you_____by_acirmo-d3lks72.jpg\r	960	t
131	http://cdnimg.visualizeus.com/thumbs/94/bd/design,double,,exposure,nature,photo,manipulation,photography,photoshop-94bd0200d9148222ad4ffa00d6c2913d_h.jpg\r	9354	t
132	http://behance.vo.llnwd.net/profiles9/368491/projects/1429749/56c598d5281d310f4cf45df55814d189.jpg\r	2878	t
133	http://th06.deviantart.net/fs71/PRE/i/2011/133/3/f/angry_bird___girl_white_bird_by_life_as_a_coder-d3g829q.jpg\r	3765	t
134	http://img.dailyinspiration.nl/201107212/13.jpg\r	2741	t
135	http://img.dailyinspiration.nl/201107212/22.jpg\r	6609	t
136	http://hypics.com/wp-content/uploads/2011/07/no-smoking-www.hypics.com_.jpg\r	4259	t
137	http://hypics.com/wp-content/uploads/2011/07/ADIDAS-SUN-www.hypics.com_.jpg\r	2377	t
138	http://shadowness.com/file/item4/105658/image_t6.jpg\r	7081	t
139	http://shadowness.com/file/item4/105941/image_t6.jpg\r	2750	t
140	http://shadowness.com/file/item4/105937/image_t6.jpg\r	4292	t
141	http://shadowness.com/file/item4/105881/image_t6.jpg\r	4094	t
142	http://3.bp.blogspot.com/-Mt__p3aqrEY/TYnhkDJTS8I/AAAAAAAAAPY/ryAWla7-IjM/s1600/neil_duerden_sony-erricsson2.jpg\r	9917	t
143	http://3.bp.blogspot.com/-jO6Qte_FQjI/TgjuJlFSdiI/AAAAAAAAAQs/45se_qrVV_g/s1600/carl-cox-promo-small.jpg\r	4966	t
144	http://photodonuts.com/wp-content/uploads/2011/07/Marie-Schmidt.jpeg\r	6415	t
145	http://photodonuts.com/wp-content/uploads/2011/07/Jonathan-Ducruix.jpeg\r	3605	t
146	http://photodonuts.com/wp-content/uploads/2011/07/Justin-Tyler-Close2.jpeg\r	2185	t
147	http://photodonuts.com/wp-content/uploads/2011/07/John-Ciamillo1.jpeg\r	5443	t
148	http://farm7.static.flickr.com/6130/5962770042_402213bff6_z.jpg\r	9065	t
149	http://farm4.static.flickr.com/3381/5768307724_3853d0418e_z.jpg\r	596	t
150	http://farm6.static.flickr.com/5067/5760209872_88649c0efc_z.jpg\r	9827	t
151	http://farm7.static.flickr.com/6023/5935133993_8fdf1e1cb4_z.jpg\r	1369	t
152	http://s3.amazonaws.com/data.tumblr.com/tumblr_lopfqkP7Ak1qiu0vao1_1280.jpg?AWSAccessKeyId=AKIAJ6IHWSU3BX3X7X3Q&amp;Expires=1311444392&amp;Signature=2Fao9H42aKxE3%2B%2BBd6Hhk12AhQE%3D\r	5680	t
153	http://blog.thaeger.com/wp-content/uploads/2011/07/hulk-yoga-maris-wicks.jpg\r	9755	t
154	http://blog.thaeger.com/wp-content/uploads/2011/07/vinyl-lover-audrey-hepburn.jpg\r	3775	t
155	http://blog.thaeger.com/wp-content/uploads/2011/05/tumblr_l55yq86gbC1qbdis4o1_400.jpg\r	4933	t
156	http://blog.thaeger.com/wp-content/uploads/2011/07/charts-ridd-sorensen.jpg\r	4697	t
157	http://zac-fashion.com/wp-content/uploads/2011/07/Herieth-Paul-by-Richard-Bernardin.jpeg\r	769	t
158	http://zac-fashion.com/wp-content/uploads/2011/07/Anais-Pouliot-by-Chadwick-Tyler.jpeg\r	9971	t
159	http://zac-fashion.com/wp-content/uploads/2011/07/Alexina-Graham-by-Tung-Walsh4.jpg\r	3320	t
160	http://zac-fashion.com/wp-content/uploads/2011/07/Anais-Pouliot-by-Horst-Diekgerdes.jpeg\r	9555	t
161	http://www.letmebeinspired.com/wp-content/uploads/2011/07/Image0000217.jpg\r	8327	t
162	http://25.media.tumblr.com/tumblr_lonj8o57Su1qzqwamo1_500.png\r	9349	t
163	http://farm7.static.flickr.com/6001/5964370116_7051581a9d_z.jpg\r	8720	t
165	http://mediacdn.disqus.com/1311382870/images/embed/bullet-feed.png\r	2114	t
172	http://mediacdn.disqus.com/uploads/users/431/6337/avatar92.jpg?1311397077\r	8540	t
173	http://media.disqus.com/uploads/anonusers/2578/6931/avatar92.jpg\r	2131	t
174	http://mediacdn.disqus.com/uploads/users/1004/6708/avatar92.jpg?1311430028\r	961	t
176	http://abduzeedo.com/files/imagecache/img210x170/originals/wp_1024-161.jpg\r	1131	t
177	http://abduzeedo.com/files/imagecache/img210x170/originals/bow181.jpg\r	2736	t
178	http://abduzeedo.com/files/imagecache/img210x170/originals/sow881.jpg\r	2449	t
180	http://abduzeedo.com/files/imagecache/img210x170/originals/capacasad10.jpg\r	1750	t
181	http://abduzeedo.com/files/imagecache/img210x170/originals/110cover.jpg	8321	t
171	http://mediacdn.disqus.com/uploads/users/870/3035/avatar92.jpg?1311390490\r	4303	f
164	http://mediacdn.disqus.com/1311382870/images/embed/email.png\r	8689	f
166	http://mediacdn.disqus.com/uploads/users/1119/3480/avatar92.jpg?1311374688\r	7849	f
167	http://mediacdn.disqus.com/1311382870/images/themes/narcissus/moderator.png\r	8318	f
168	http://mediacdn.disqus.com/uploads/users/378/1265/avatar92.jpg?1280455262\r	5538	f
169	http://media.disqus.com/uploads/forums/7/2935/avatar92.jpg\r	6821	f
170	http://mediacdn.disqus.com/uploads/users/510/1158/avatar92.jpg?1309987152\r	6407	f
175	http://media.disqus.com/uploads/anonusers/1852/3820/avatar92.jpg\r	3862	f
179	http://abduzeedo.com/files/imagecache/img210x170/originals/ufeedmeback-teaser_0.jpg\r	9183	f
\.


--
-- TOC entry 1849 (class 0 OID 16574)
-- Dependencies: 1524
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY questions (id, question, answer) FROM stdin;
2	quanti anni ho?	12c6fc06c99a462375eeb3f43dfd832b08ca9e17
3	test	a94a8fe5ccb19ba61c4c0873d391e987982fbbd3
4	test	a94a8fe5ccb19ba61c4c0873d391e987982fbbd3
\.


--
-- TOC entry 1850 (class 0 OID 16582)
-- Dependencies: 1525
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sessions (session_id, ip_address, user_agent, last_activity) FROM stdin;
\.


--
-- TOC entry 1851 (class 0 OID 16593)
-- Dependencies: 1527
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (id, group_id, banned_id, country_id, question_id, username, password, email, hash, activation_code, forgotten_password_code) FROM stdin;
2	2	0	0	2	admin	f42e72910d29bad2fafde4cac4907f2c75f782c5	filippo.riggio@intesys.it	755c7a101545e725d0240cde2549695e789fc075		
\.


-- Completed on 2011-07-24 16:24:25

--
-- PostgreSQL database dump complete
--


