$(document).ready(function () {

    const getLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, error);
        } else {

        }
    }

    const showPosition = (position) => {
        let x = Math.abs(position.coords.latitude);
        let y = Math.abs(position.coords.longitude);
        if (!(x <= Math.abs(-30.7340) && x >= Math.abs(-30.7390) && y >= Math.abs(-57.9740) && y <= Math.abs(-57.9780))) {
            $(".geoWarning").removeAttr("hidden", "");
            $(".geoButton").attr("disabled", "");
        };
    }
    const error = (err) => {
        let geo = document.getElementById('geoWarning')
        geo.textContent = 'Este dispositivo no cuenta con GeoLocalización o no se encuentra activa.';
        $(".geoWarning").removeAttr("hidden", "");
        $(".geoButton").attr("disabled", "");
    };
    getLocation()

})