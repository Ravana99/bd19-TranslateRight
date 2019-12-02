DROP FUNCTION IF EXISTS update_anomalia_proc() CASCADE;
DROP FUNCTION IF EXISTS insert_anomalia_traducao_proc() CASCADE;
DROP FUNCTION IF EXISTS update_anomalia_traducao_proc() CASCADE;
DROP FUNCTION IF EXISTS insert_user_proc() CASCADE;
DROP FUNCTION IF EXISTS insert_reg_user_proc() CASCADE;
DROP FUNCTION IF EXISTS insert_qual_user_proc() CASCADE;
DROP FUNCTION IF EXISTS update_reg_user_proc() CASCADE;
DROP FUNCTION IF EXISTS update_qual_user_proc() CASCADE;
DROP FUNCTION IF EXISTS delete_reg_user_proc() CASCADE;
DROP FUNCTION IF EXISTS delete_qual_user_proc() CASCADE;


/* RI-1 */

CREATE OR REPLACE FUNCTION update_anomalia_proc() RETURNS TRIGGER AS
$$
DECLARE b BOX;
BEGIN
    SELECT zona2 INTO b FROM anomalia_traducao WHERE id=new.id;
    IF b IS NOT NULL AND b && new.zona THEN
        RAISE EXCEPTION 'Zona AND zona2 must not overlap';
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_anomalia BEFORE UPDATE ON anomalia
FOR EACH ROW EXECUTE PROCEDURE update_anomalia_proc();


CREATE OR REPLACE FUNCTION insert_anomalia_traducao_proc() RETURNS TRIGGER AS
$$
DECLARE b BOX;
BEGIN
    IF new.id NOT IN (SELECT id FROM anomalia) THEN
        RAISE EXCEPTION 'Please insert an anomalia with that id first';
    ELSIF new.id NOT IN (SELECT id FROM anomalia WHERE id=new.id AND tem_anomalia_redacao=false) THEN
        RAISE EXCEPTION 'The anomalia id introduced does not require zona2/lingua2 values';
    else
        SELECT zona INTO b FROM anomalia WHERE id=new.id;
        IF b && new.zona2 THEN
            RAISE EXCEPTION 'Zona AND zona2 must not overlap';
        END IF;
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_anomalia_traducao BEFORE INSERT ON anomalia_traducao
FOR EACH ROW EXECUTE PROCEDURE insert_anomalia_traducao_proc();


CREATE OR REPLACE FUNCTION update_anomalia_traducao_proc() RETURNS TRIGGER AS
$$
DECLARE b BOX;
BEGIN
    SELECT zona INTO b FROM anomalia WHERE id=new.id;
    IF b && new.zona2 THEN
        RAISE EXCEPTION 'Zona AND zona2 must not overlap';
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_anomalia_traducao BEFORE UPDATE ON anomalia_traducao
FOR EACH ROW EXECUTE PROCEDURE update_anomalia_traducao_proc();



/* RI-4, RI-5, RI-6 */

CREATE OR REPLACE FUNCTION insert_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    INSERT INTO utilizador_regular VALUES (new.email);
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_user AFTER INSERT ON utilizador
FOR EACH ROW EXECUTE PROCEDURE insert_user_proc();


CREATE OR REPLACE FUNCTION insert_reg_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF new.email IN (SELECT email FROM utilizador_qualificado) THEN
        DELETE FROM utilizador_qualificado WHERE email=new.email;
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_reg_user AFTER INSERT ON utilizador_regular
FOR EACH ROW EXECUTE PROCEDURE insert_reg_user_proc();


CREATE OR REPLACE FUNCTION insert_qual_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF new.email IN (SELECT email FROM utilizador_regular) THEN
        DELETE FROM utilizador_regular WHERE email=new.email;
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER insert_qual_user AFTER INSERT ON utilizador_qualificado
FOR EACH ROW EXECUTE PROCEDURE insert_qual_user_proc();



CREATE OR REPLACE FUNCTION update_reg_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF new.email IN (SELECT email FROM utilizador_qualificado) THEN
        RAISE EXCEPTION 'Please update the table utilizador to update user emails.';
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_reg_user BEFORE UPDATE ON utilizador_regular
FOR EACH ROW EXECUTE PROCEDURE update_reg_user_proc();

CREATE OR REPLACE FUNCTION update_qual_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF new.email IN (SELECT email FROM utilizador_regular) THEN
        RAISE EXCEPTION 'PleASe update the table utilizador to update user emails.';
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_qual_user BEFORE UPDATE ON utilizador_qualificado
FOR EACH ROW EXECUTE PROCEDURE update_qual_user_proc();


CREATE OR REPLACE FUNCTION delete_reg_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF (old.email NOT IN (SELECT email FROM utilizador_qualificado) AND old.email IN (SELECT email FROM utilizador)) THEN
        INSERT INTO utilizador_qualificado values (old.email);
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_reg_user AFTER DELETE ON utilizador_regular
FOR EACH ROW EXECUTE PROCEDURE delete_reg_user_proc();


CREATE OR REPLACE FUNCTION delete_qual_user_proc() RETURNS TRIGGER AS
$$
BEGIN
    IF (old.email NOT IN (SELECT email FROM utilizador_regular) AND old.email IN (SELECT email FROM utilizador)) THEN
        INSERT INTO utilizador_regular values (old.email);
    END IF;
    RETURN new;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER delete_qual_user AFTER DELETE ON utilizador_qualificado
FOR EACH ROW EXECUTE PROCEDURE delete_qual_user_proc();
