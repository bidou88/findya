var Person = function(name, latitude, longitude) {
    var name = name,
        latitude = latitude,
        longitude = longitude,
        id;

    var getName = function() {
        return name;
    };

    var getLatitude = function() {
        return latitude;
    };

    var getLongitude = function() {
        return longitude;
    };

    var setName = function(newName) {
        name = newName;
    };

    var setLatitude = function(newLatitude) {
        latitude = newLatitude;
    };

    var setLongitude = function(newLongitude) {
        longitude = newLongitude;
    };

    return {
        getName: getName,
        getLatitude: getLatitude,
        getLongitude: getLongitude,
        setName: setName,
        setLatitude: setLatitude,
        setlongitude: setLongitude,
        id: id
    }
};

exports.Person = Person;