-- create_pokemon_db.sql

CREATE DATABASE IF NOT EXISTS pokedex;
USE pokedex;

CREATE TABLE IF NOT EXISTS pokemon (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    ataque INT NOT NULL
);

-- Insertar algunos Pokemón
INSERT INTO pokemon (nombre, tipo, ataque) VALUES
('Pikachu', 'Eléctrico', 55),
('Charmander', 'Fuego', 60),
('Bulbasaur', 'Planta', 49),
('Squirtle', 'Agua', 50),
('Dragonite', 'Dragón/Volador', 134);
