const meteoDisplay = document.querySelector('.header__meteo');
const secondHand = document.querySelector('.second-hand');
const minHand = document.querySelector('.min-hand');
const hourHand = document.querySelector('.hour-hand');

// STATION METEO
const fetchWeather = async function (town) {
    // url à laquelle on interpole la saisie utilisateur
    const url = `https://api.openweathermap.org/data/2.5/weather?q=${town}&appid=67173c519205d685b546a19f56219ebc&lang=fr`;

    // requête météo
    const townWeather = await axios.get(url);

    // insertion encart météo
    if (townWeather) {
        // variables
        const weatherContainer = document.querySelector('.header__meteo');
        const townTemp = Math.trunc(townWeather.data.main.temp - 273.15);
        const tempMin = Math.trunc(townWeather.data.main.temp_min - 273.15);
        const tempMax = Math.trunc(townWeather.data.main.temp_max - 273.15);
        const townSky = townWeather.data.weather[0].description;
        let icon;

        switch (townSky) {
            case 'couvert':
                icon = `./assets/img/001-cloudy day.png`;
                break;
            case 'ensoleillé':
                icon = `./assets/img/002-sunny.png`;
                break;
            case 'nuageux':
                icon = `./assets/img/001-cloudy day.png`;
                break;
            case 'peu nuageux':
                icon = `./assets/img/005-cloudy.png`;
                break;
            case 'partiellement nuageux':
                icon = `./assets/img/005-cloudy.png`;
                break;
            case 'ciel dégagé':
                icon = `./assets/img/002-sunny.png`;
                break;
            case 'brume':
                icon = `./assets/img/007-windy.png`;
                break;
            case 'légères chutes de neige':
                icon = `./assets/img/006-snowy.png`;
                break;
        }

        weatherContainer.innerHTML = '';

        weatherContainer.insertAdjacentHTML(
            'beforeend',
            `   
                <img src="${icon}" id="weatherIcon" /> 
                <p>${town}: ${townTemp}°C, ${townSky}. </p>
                         
        `
        );
    }
};

const setDate = function () {
    //récupération de l'heure
    const now = new Date();

    // secondes
    const seconds = now.getSeconds();
    const secondsDegrees = (seconds / 60) * 360 + 90;
    // condition pour éviter l'animation qui retourne en arrière quand l'aiguille est sur 0
    if (secondsDegrees === 90) {
        secondHand.style.transition = 'all 0s';
    } else {
        secondHand.style.transition = 'all 0.05s';
        secondHand.style.transitionTimingFunction = 'cubic-bezier(0.1, 2.38, 0.8,-0.25)';
    }
    secondHand.style.transform = `rotate(${secondsDegrees}deg)`;

    // minutes
    const minutes = now.getMinutes();
    const minutesDegrees = (minutes / 60) * 360 + 90;
    if (minutesDegrees === 90) {
        minHand.style.transition = 'all 0s';
    } else {
        minHand.style.transition = 'all 0.05s';
    }
    minHand.style.transform = `rotate(${minutesDegrees}deg)`;

    // heures
    const hour = now.getHours();
    const hourDegrees = (hour / 12) * 360 + 90;
    if (hourDegrees === 90) {
        hourHand.style.transition = 'all 0s';
    } else {
        hourHand.style.transition = 'all 0.05s';
    }
    hourHand.style.transform = `rotate(${hourDegrees}deg)`;
};

setInterval(setDate, 1000);

window.addEventListener('load', function () {
    if (meteoDisplay) fetchWeather('Marseille');
});
