var Person = function(mapIdPerson, namePerson, lat, lng) {
    var mapId = mapIdPerson,
        name = namePerson,
        latitude = lat,
        longitude = lng,
        id;

    var getMapId = function() {
        return this.mapId;
    };    

    var getName = function() {
        return this.name;
    };

    var getLatitude = function() {
        return this.latitude;
    };

    var getLongitude = function() {
        return this.longitude;
    };

    var setMapId = function(newMapId) {
        this.mapId = newMapId;
    };

    var setName = function(newName) {
        this.name = newName;
    };

    var setLatitude = function(newLatitude) {
        this.latitude = newLatitude;
    };

    var setLongitude = function(newLongitude) {
        this.longitude = newLongitude;
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