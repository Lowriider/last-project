mymap = L.map('carte').setView([45.862933, 6.183714], 11);

class mapClass {
    constructor() {
        this.initMap();
        this.markerPos();
    }
    // initialisation de la map //
    initMap() {
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            attribution: '© les contributeurs d’OpenStreetMap',
            maxZoom: 20,
            minZoom: 12,
            opacity:0.6
        }).addTo(mymap);
    }

    // envoie requete HTML // 

    markerPos() {
        var request = new XMLHttpRequest();
        request.open("GET", "https://raw.githubusercontent.com/Lowriider/last-project/master/public/json/coord.json");
        request.onload = function () {
                let data = JSON.parse(this.responseText); // recupere les datas de JCDecaux et place les marqueurs sur la carte //
                for (let i = 0; i < data.shop.length; i++) {
                    let long = data.shop[i].long;
                    let lat = data.shop[i].lat;
                    let phoneNb = data.shop[i].phone;
                    let address = data.shop[i].address;
                    let url = data.shop[i].url;
                    let name = data.shop[i].name;
                    

                    let marker = L.marker([long,lat]).addTo(mymap);
                    marker.bindPopup(`<p>${name}</p><p>Adresse: ${address}</p><p>Téléphone: ${phoneNb}</p><a href="${url}">site web</p>`);
                }
        }
        request.send();
    }
}
let mapVelos = new mapClass();