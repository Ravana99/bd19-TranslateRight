drop function if exists update_anomalia_proc() cascade;
drop function if exists insert_anomalia_traducao_proc() cascade;
drop function if exists update_anomalia_traducao_proc() cascade;
drop function if exists insert_user_proc() cascade;
drop function if exists insert_reg_user_proc() cascade;
drop function if exists insert_qual_user_proc() cascade;
drop function if exists update_reg_user_proc() cascade;
drop function if exists update_qual_user_proc() cascade;
drop function if exists delete_reg_user_proc() cascade;
drop function if exists delete_qual_user_proc() cascade;


/* RI-1 */

create or replace function update_anomalia_proc() returns trigger as
$$
declare b box;
begin
    select zona2 into b from anomalia_traducao where id=new.id;
    if b is not null and b && new.zona then
        raise exception 'Zona and zona2 must not overlap';
    end if;
    return new;
end
$$ language plpgsql;

create trigger update_anomalia before update on anomalia
for each row execute procedure update_anomalia_proc();


create or replace function insert_anomalia_traducao_proc() returns trigger as
$$
declare b box;
begin
    if new.id not in (select id from anomalia) then
        raise exception 'Please insert an anomalia with that id first';
    elsif new.id not in (select id from anomalia where id=new.id and tem_anomalia_redacao=false) then
        raise exception 'The anomalia id introduced does not require zona2/lingua2 values';
    else
        select zona into b from anomalia where id=new.id;
        if b && new.zona2 then
            raise exception 'Zona and zona2 must not overlap';
        end if;
    end if;
    return new;
end
$$ language plpgsql;

create trigger insert_anomalia_traducao before insert on anomalia_traducao
for each row execute procedure insert_anomalia_traducao_proc();


create or replace function update_anomalia_traducao_proc() returns trigger as
$$
declare b box;
begin
    select zona into b from anomalia where id=new.id;
    if b && new.zona2 then
        raise exception 'Zona and zona2 must not overlap';
    end if;
    return new;
end
$$ language plpgsql;

create trigger update_anomalia_traducao before update on anomalia_traducao
for each row execute procedure update_anomalia_traducao_proc();



/* RI-4, RI-5, RI-6 */

create or replace function insert_user_proc() returns trigger as
$$
begin
    insert into utilizador_regular values(new.email);
    return new;
end
$$ language plpgsql;

create trigger insert_user after insert on utilizador
for each row execute procedure insert_user_proc();


create or replace function insert_reg_user_proc() returns trigger as
$$
begin
    if new.email in (select email from utilizador_qualificado) then
        delete from utilizador_qualificado where email = new.email;
    end if;
    return new;
end
$$ language plpgsql;

create trigger insert_reg_user after insert on utilizador_regular
for each row execute procedure insert_reg_user_proc();


create or replace function insert_qual_user_proc() returns trigger as
$$
begin
    if new.email in (select email from utilizador_regular) then
        delete from utilizador_regular where email = new.email;
    end if;
    return new;
end
$$ language plpgsql;

create trigger insert_qual_user after insert on utilizador_qualificado
for each row execute procedure insert_qual_user_proc();



create or replace function update_reg_user_proc() returns trigger as
$$
begin
    if new.email in (select email from utilizador_qualificado) then
        raise exception 'Please update the table utilizador to update user emails.';
    end if;
    return new;
end
$$ language plpgsql;

create trigger update_reg_user before update on utilizador_regular
for each row execute procedure update_reg_user_proc();

create or replace function update_qual_user_proc() returns trigger as
$$
begin
    if new.email in (select email from utilizador_regular) then
        raise exception 'Please update the table utilizador to update user emails.';
    end if;
    return new;
end
$$ language plpgsql;

create trigger update_qual_user before update on utilizador_qualificado
for each row execute procedure update_qual_user_proc();


create or replace function delete_reg_user_proc() returns trigger as
$$
begin
    if (old.email not in (select email from utilizador_qualificado) and old.email in (select email from utilizador)) then
        insert into utilizador_qualificado values(old.email);
    end if;
    return new;
end
$$ language plpgsql;

create trigger delete_reg_user after delete on utilizador_regular
for each row execute procedure delete_reg_user_proc();


create or replace function delete_qual_user_proc() returns trigger as
$$
begin
    if (old.email not in (select email from utilizador_regular) and old.email in (select email from utilizador)) then
        insert into utilizador_regular values(old.email);
    end if;
    return new;
end
$$ language plpgsql;

create trigger delete_qual_user after delete on utilizador_qualificado
for each row execute procedure delete_qual_user_proc();




