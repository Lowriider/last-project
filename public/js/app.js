class weatherClass {
    constructor(){

        this.getWeatherInfos();
    }

    getWeatherInfos() {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                var infos = JSON.parse(this.responseText); // recupere les datas de JCDecaux et place les marqueurs sur la carte //
                console.log(infos);
                let city = infos.name;
                let wind = infos.wind.speed;
                let temp = infos.main.temp;

                for (let i = 0; i < infos.weather.length; i++) {
                    let actualWeather = infos.weather[i].description;
                    let icon = infos.weather[i].icon;
                    console.log(actualWeather);
                    let iconUrl = `<img src="http://openweathermap.org/img/wn/${icon}.png">`;
                    let cityDiv = document.getElementById("city");
                    let windDiv = document.getElementById("wind");
                    let tempDiv = document.getElementById("temp");
                    let actualWeatherDiv = document.getElementById('actualWeather');
                    let iconDiv = document.getElementById("icon");

                    cityDiv.innerHTML = `<h1>${city}</h1>`;
                    windDiv.innerHTML = `<p>Force du vent: ${wind}m/s</p>`;
                    tempDiv.innerHTML = `<h1>${temp}°C</h1>`;
                    actualWeatherDiv.innerHTML = `<h1>${actualWeather}</h1>`;
                    iconDiv.innerHTML = `<p>${iconUrl}</p>`;
                }
            }
        };
        request.open("GET", "https://api.openweathermap.org/data/2.5/weather?q=Annecy&lang=fr&units=metric&appid=7d4d1d17a14823aa345b8105f9b94eb9");
        request.send();
    }      

}

let weatherapp = new weatherClass();

