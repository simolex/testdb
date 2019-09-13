alter table OTHERGKN.VER_BLOCKS add bl_id number;
-- Add comments to the columns 
comment on column OTHERGKN.VER_BLOCKS.id
  is 'kls_code';
comment on column OTHERGKN.VER_BLOCKS.bl_id
  is 'id';
-- Drop primary, unique and foreign key constraints 
alter table OTHERGKN.VER_BLOCKS
  drop constraint PK$VER_BLOCKS cascade;
-- Create/Recreate indexes 
create index OTHERGKN.I$OG$VER_BLOCKS$code on OTHERGKN.VER_BLOCKS (id)
  tablespace OTHERGKN_IND
  storage
  (
    initial 64K
    minextents 1
    maxextents unlimited
  );

-- Create/Recreate primary, unique and foreign key constraints 
alter table OTHERGKN.VER_BLOCKS
  add constraint PK_VER_BLOCKS primary key (BL_ID)
  using index 
  tablespace OTHERGKN_IND
  pctfree 10
  initrans 2
  maxtrans 255
  storage
  (
    initial 64K
    next 1M
    minextents 1
    maxextents unlimited
  );

create sequence OTHERGKN.SEQ_VER_BLOCKS_ID
minvalue 1
maxvalue 9999999999999999999999999999
start with 141
increment by 1
cache 2;