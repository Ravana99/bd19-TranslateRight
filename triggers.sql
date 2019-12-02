create trigger insert_user after insert on utilizador
for each row execute procedure insert_user_proc();

create or replace function insert_user_proc() returns trigger as
$$
begin
    insert into utilizador_regular values(new.email);
end
$$ language plpgsql;