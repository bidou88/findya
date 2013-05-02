var util = require("util"),
	io = require("socket.io"),
	Person = require("./Person").Person;

var socket,
	persons;

function init() {

	persons = [];

	socket = io.listen(8000);

	socket.configure(function() {
		socket.set("transports", ["websocket"]);
		socket.set("log level", 2);
	});

	setEventHandlers();
};

var setEventHandlers = function() {

	socket.sockets.on("connection", onSocketConnection);
};

function onSocketConnection(client) {

	util.log("Person is connected: "+client.id);

	client.on("disconnect", onClientDisconnect);

	client.on("new person", onNewPerson);

	client.on("update location", onUpdateLocation);

	client.on("remove person", onRemovePerson);
};

function onClientDisconnect() {

	var person = personById(this.id);

	util.log("Person is disconnected: "+this.id+" - "+person.getName());

	persons.splice(persons.indexOf(person), 1);

	this.broadcast.emit("remove person", {mapId: person.getMapId(), id: person.id, name: person.getName(), latitude: person.getLatitude(), longitude: person.getLongitude()});
};

function onNewPerson(data) {

	var newPerson = new Person(data.mapId, data.name);
	newPerson.id = this.id;

	persons.push(newPerson);

	for (var i = 0; i < persons.length; i++) {
		if(persons[i].getMapId()==data.mapId && persons[i].id != this.id) {
			util.log("Server envoi to " +newPerson.id+" - "+newPerson.getName()+" sur map "+data.mapId+ " l'ID suivant "+persons[i].id);
			this.emit("add person", {mapId: persons[i].getMapId(), id: persons[i].id, name: persons[i].getName(), latitude: persons[i].getLatitude(), longitude: persons[i].getLongitude()});
		}
	}

	util.log("New person created : " +newPerson.id+" - "+newPerson.getName());
	this.broadcast.emit("new person", {mapId: newPerson.getMapId(), id: newPerson.id, name: newPerson.getName()});
	
};

function onUpdateLocation(data) {
	lat = data.latitude;
	lng = data.longitude;

	var person = personById(this.id);
	person.setLatitude(lat);
	person.setLongitude(lng);

	util.log("Server updated location of "+this.id+" - "+person.getName()+" with lat = "+person.getLatitude()+" lng = "+person.getLongitude());
	this.broadcast.emit("update location", {mapId: person.getMapId(), id: person.id, name: person.getName(), latitude: person.getLatitude(), longitude: person.getLongitude()});
};

function onRemovePerson(data) {
	

};

function personById(id) {
	for (var i = 0; i < persons.length; i++) {
		if (persons[i].id == id) {
			return persons[i];
		}	
	};
	return false;
};

init();