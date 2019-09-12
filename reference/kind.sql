-- Create table
create table OTHERGKN.VER_KINDS
(
  id   NUMBER not null,
  name VARCHAR2(200) not null
)
tablespace OTHERGKN_DATA
  pctfree 10
  initrans 1
  maxtrans 255
  storage
  (
    initial 64
    minextents 1
    maxextents unlimited
  );
-- Create/Recreate primary, unique and foreign key constraints 
alter table OTHERGKN.VER_KINDS
  add constraint PK_VER_KINDS primary key (ID)
  using index 
  tablespace OTHERGKN_IND
  pctfree 10
  initrans 2
  maxtrans 255;