


    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);

    function successCallback(position) {

      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      $(".latitude-input").val(latitude);
      $(".longitude-input").val(longitude);
    }

    function errorCallback(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
              alert("User denied the request for Geolocation.");
              break;
            case error.POSITION_UNAVAILABLE:
                alert("Location information is unavailable.");
              break;
            case error.TIMEOUT:
                alert("The request to get user location timed out.");
              break;
            case error.UNKNOWN_ERROR:
                alert("An unknown error occurred.");
              break;
          }
    }


