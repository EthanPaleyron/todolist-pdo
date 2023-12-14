/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de cr�ation :  20/11/2023 09:26:03                      */
/*==============================================================*/


drop table if exists TODOLIST;

drop table if exists UTILISATEURS;

/*==============================================================*/
/* Table : TODOLIST                                             */
/*==============================================================*/
create table TODOLIST
(
   ID_TODOLIST          int not null Auto_increment,
   ID_UTILISATEUR       int not null,
   CONTENU              varchar(300000),
   DATE              DateTime,
   primary key (ID_TODOLIST)
);

/*==============================================================*/
/* Table : UTILISATEURS                                         */
/*==============================================================*/
create table UTILISATEURS
(
   ID_UTILISATEUR       int not null Auto_increment,
   NOM_UTILISATEUR      varchar(256),
   MDP_UTILISATEUR      varchar(256),
   primary key (ID_UTILISATEUR)
);

alter table UTILISATEURS add unique(`NOM_UTILISATEUR`)
alter table TODOLIST ENGINE = InnoDB;
alter table UTILISATEURS ENGINE = InnoDB;

alter table TODOLIST add constraint FK_POSSEDE foreign key (ID_UTILISATEUR)
      references UTILISATEURS (ID_UTILISATEUR) on delete restrict on update restrict;

