var Person = function(mapId, name, lat, lng) {
    var mapId = mapId,
        name = name,
        latitude = lat,
        longitude = lng,
        id;

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
        getMapId: getMapId,
        getName: getName,
        getLatitude: getLatitude,
        getLongitude: getLongitude,
        setMapId: setMapId,
        setName: setName,
        setLatitude: setLatitude,
        setlongitude: setLongitude,
        id: id
    }
};

exports.Person = Person;