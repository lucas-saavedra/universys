$(document).ready(function () {

    const getLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }

    const showPosition = (position) => {
        let x = Math.abs(position.coords.latitude);
        let y = Math.abs(position.coords.longitude);
        return x <= Math.abs(-30.7350) && x >= Math.abs(-30.7370) && y >= Math.abs(-57.9760) && y <= Math.abs(-57.9780) ? true : false;

    }
    if (!getLocation()) {
        $(".geoWarning").removeAttr("hidden", "");
        $(".geoButton").attr("disabled", "");
    }

})