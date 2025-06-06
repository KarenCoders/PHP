document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.getElementById('search-btn');
    const pokemonNameInput = document.getElementById('pokemon-name');
    const resultContainer = document.getElementById('pokemon-result');

    // Crear un contenedor para las sugerencias debajo del input
    let suggestionsList = document.createElement('ul');
    suggestionsList.id = 'suggestions';
    suggestionsList.style.listStyle = 'none';
    suggestionsList.style.padding = '0';
    suggestionsList.style.margin = '5px auto 0 auto';
    suggestionsList.style.maxWidth = '220px';
    suggestionsList.style.textAlign = 'left';
    suggestionsList.style.border = '1px solid #ccc';
    suggestionsList.style.borderRadius = '4px';
    suggestionsList.style.backgroundColor = '#fff';
    suggestionsList.style.position = 'absolute';
    suggestionsList.style.zIndex = '1000';
    suggestionsList.style.cursor = 'pointer';

    // Posicionar la lista de sugerencias justo debajo del input
    pokemonNameInput.parentNode.style.position = 'relative';
    pokemonNameInput.parentNode.appendChild(suggestionsList);

    let pokemonsList = [];

    // Cargar la lista completa de Pokémon desde la API oficial
    fetch('https://pokeapi.co/api/v2/pokemon?limit=10000')
        .then(response => response.json())
        .then(data => {
            pokemonsList = data.results.map(p => p.name);
        })
        .catch(() => {
            console.error('No se pudo cargar la lista de Pokémon');
        });

    searchBtn.addEventListener('click', buscarPokemon);
    pokemonNameInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') buscarPokemon();
    });

    pokemonNameInput.addEventListener('input', mostrarSugerencias);

    function buscarPokemon() {
        const nombre = pokemonNameInput.value.trim().toLowerCase();
        clearSuggestions();

        if (!nombre) {
            resultContainer.innerHTML = '<p class="error">Ingresa un nombre de Pokémon</p>';
            return;
        }

        resultContainer.innerHTML = '<p>Buscando Pokémon...</p>';

        fetch(`fetch_pokemon.php?pokemon=${nombre}`)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw new Error(err.error); });
                }
                return response.json();
            })
            .then(data => {
                mostrarPokemon(data);
            })
            .catch(error => {
                resultContainer.innerHTML = `<p class="error">${error.message}</p>`;
            });
    }

    function mostrarPokemon(pokemon) {
        resultContainer.innerHTML = `
            <h2>${pokemon.name.toUpperCase()}</h2>
            <img src="${pokemon.sprites.front_default}" class="pokemon-image" alt="${pokemon.name}">
            <p><strong>Tipo:</strong> ${pokemon.types.map(t => t.type.name).join(', ')}</p>
            <p><strong>Altura:</strong> ${pokemon.height / 10} m</p>
            <p><strong>Peso:</strong> ${pokemon.weight / 10} kg</p>
            <p><strong>Habilidades:</strong> ${pokemon.abilities.map(a => a.ability.name).join(', ')}</p>
        `;
    }

    function mostrarSugerencias() {
        const query = pokemonNameInput.value.trim().toLowerCase();

        if (!query) {
            clearSuggestions();
            return;
        }

        // Filtrar y limitar a máximo 10 sugerencias
        const matches = pokemonsList.filter(name => name.startsWith(query)).slice(0, 10);
        renderSuggestions(matches);
    }

    function renderSuggestions(list) {
        clearSuggestions();
        if (list.length === 0) return;

        list.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item;
            li.style.padding = '5px 10px';
            li.style.borderBottom = '1px solid #eee';

            li.addEventListener('mouseenter', () => {
                li.style.backgroundColor = '#e53935';
                li.style.color = '#fff';
            });
            li.addEventListener('mouseleave', () => {
                li.style.backgroundColor = '#fff';
                li.style.color = '#000';
            });

            li.addEventListener('click', () => {
                pokemonNameInput.value = item;
                clearSuggestions();
                buscarPokemon();
            });

            suggestionsList.appendChild(li);
        });
    }

    function clearSuggestions() {
        suggestionsList.innerHTML = '';
    }
});
