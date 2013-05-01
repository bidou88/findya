var Person = function(mapIdPerson, namePerson) {
    var mapId = mapIdPerson,
        name = namePerson,
        latitude,
        longitude,
        id;

    var getId = function() {
        return id;
    }

    var getMapId = function() {
        return mapId;
    };    

    var getName = function() {
        return name;
    };

    var getLatitude = function() {
        return latitude;
    };

    var getLongitude = function() {
        return longitude;
    };

    var setMapId = function(newMapId) {
        mapId = newMapId;
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
        getId: getId,
        getMapId: getMapId,
        getName: getName,
        getLatitude: getLatitude,
        getLongitude: getLongitude,
        setMapId: setMapId,
        setName: setName,
        setLatitude: setLatitude,
        setLongitude: setLongitude
    }
};

exports.Person = Person;