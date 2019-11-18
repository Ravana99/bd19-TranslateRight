create table local_publico (
    latitude 	numeric(8,6) not null,
    longitude   numeric(9,6) not null,
    nome      	varchar(100) not null,
    constraint pk_local_publico primary key(latitude, longitude)
);

create table item (
    id          integer not null unique,
    descricao   varchar(2000) not null,
    localizacao varchar(100) not null,
    latitude    numeric(8,6) not null,
    longitude   numeric(9,6) not null,
    constraint pk_item primary key(id),
    constraint fk_item_local_publico foreign key(latitude, longitude) references local_publico(latitude, longitude)
);

create table anomalia (
    id          integer not null unique,
    zona        box((float,float),(float,float)) not null,
    imagem      varchar(1000) not null,
    lingua      varchar(100) not null,
    ts          timestamp with time zone not null,
    descricao   varchar(2000) not null,
    tem_anomalia_redacao boolean not null,
    constraint pk_anomalia primary key(id)
);

create table anomalia_traducao (
    id integer not null unique,
    zona2 box((float,float),(float,float)) not null,
    lingua2 varchar(100) not null,
    constraint pk_anomalia_traducao primary key(id),
    constraint fk_anomalia_traducao_anomalia foreign key(id) references anomalia(id)
);
/* Missing constraints RI-1 and RI-2 */

create table duplicado (
    item1 integer not null,
    item2 integer not null,
    constraint pk_duplicado primary key(item1, item2),
    constraint fk_duplicado_item1 foreign key(item1) references item(id),
    constraint fk_duplicado_item2 foreign key(item2) references item(id)
);
/* Missing constraint RI-3 */

create table utilizador (
    email varchar(100) not null unique,
    password varchar(100) not null,
    constraint pk_utilizador primary key(email)
);
/* Missing constraint RI-4 */

create table utilizador_qualificado (
    email varchar(100) not null unique,
    constraint pk_utilizador_qualificado primary key(email),
    constraint fk_utilizador_qualificado_utilizador foreign key(email) references utilizador(email)
);
/* Missing constraint RI-5 */

create table utilizador_regular (
    email varchar(100) not null unique,
    constraint pk_utilizador_regular primary key(email),
    constraint fk_utilizador_regular_utilizador foreign key(email) references utilizador(email)
);
/* Missing constraint RI-6 */

create table incidencia (
    anomalia_id integer not null unique,
    item_id integer not null,
    email varchar(100) not null,
    constraint pk_incidencia primary key(anomalia_id),
    constraint fk_incidencia_anomalia foreign key(anomalia_id) references anomalia(id),
    constraint fk_incidencia_item foreign key(item_id) references item(id),
    constraint fk_incidencia_utilizador foreign key(email) references utilizador(email)
);

create table proposta_de_correcao (
    email varchar(100) not null,
    nro integer not null,
    data_hora timestamp with time zone not null,
    texto varchar(2000) not null,
    constraint pk_proposta_de_correcao primary key(email, nro),
    constraint fk_proposta_de_correcao_utilizador_qualificado foreign key(email) references utilizador_qualificado(email)
);
/* Missing constraint RI-7 */

create table correcao (
    email varchar(100) not null,
    nro integer not null,
    anomalia_id integer not null,
    constraint pk_correcao primary key(email, nro, anomalia_id),
    constraint fk_correcao_proposta_de_correcao foreign key(email, nro) references proposta_de_correcao(email, nro),
    constraint fk_correcao_incidencia foreign key(anomalia_id) references incidencia(anomalia_id)
);














