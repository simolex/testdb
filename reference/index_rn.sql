ALTER INDEX othergkn.i$og$ver_blocks$type RENAME TO i_og_ver_blocks_type;
ALTER INDEX othergkn.i$og$ver_blocks$kind RENAME TO i_og_ver_blocks_kind;
ALTER INDEX othergkn.i$og$ver_blocks$block_type RENAME TO i_og_ver_blocks_block_type;
ALTER INDEX othergkn.i$og$ver_blocks$code RENAME TO i_og_ver_blocks_code;
ALTER INDEX othergkn.i$ver_process$block_id RENAME TO i_ver_process_block_id;
ALTER INDEX othergkn.i$ver_process$parent_id RENAME TO i_ver_process_parent_id;
ALTER INDEX othergkn.fk$ver_proc_stages RENAME TO fk_ver_proc_stages;