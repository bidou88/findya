var Person = function(lat, long) {
    var latitude = latitude,
        longitude = longitude,
        id;
    
    var getLatitude = function() {
        return latitude;
    };

    var getLongitude = function() {
        return longitude;
    };

    var setLatitude = function(newLatitude) {
        latitude = newLatitude;
    };

    var setLongitude = function(newLongitude) {
        longitude = newLongitude;
    };

    return {
        getLatitude: getLatitude,
        getLongitude: getLongitude,
        setLatitude: setLatitude,
        setlongitude: setLongitude,
        id: id
    }
};

exports.Person = Person;