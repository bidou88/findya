var util = require("util"),
	io = require("socket.io"),
	Person = require("./Person").Person;

var socket,
	persons;

function init() {

	persons = [];

	socket = io.listen(8000	);

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

	util.log("Person is disconnected: "+this.id);

	var person = personById(this.id);

	persons.splice(persons.indexOf(person), 1);

	this.broadcast.emit("remove person", {mapId: person.mapId, id: person.id, name: person.name, latitude: person.getLatitude(), longitude: person.getLongitude()});

};

function onNewPerson(data) {

	var newPerson = new Person(data.mapId, data.name, data.latitude, data.longitude);
	newPerson.id = this.id;

	persons.push(newPerson);

	for (var i = 0; i < persons.length; i++) {
		if(persons[i].getMapId()==data.mapId) {
			util.log("Server envoi to " +newPerson.id+ " sur map "+data.mapId+ " l'ID suivant "+persons[i].id);
			this.emit("add person", {mapId: persons[i].mapId, id: persons[i].id, name: persons[i].name, latitude: persons[i].getLatitude(), longitude: persons[i].getLongitude()});
		}
	}
	util.log("Server envoi to : ALL sauf " +newPerson.id);
	this.broadcast.emit("new person", {mapId: newPerson.mapId, id: newPerson.id, name: newPerson.name, latitude: newPerson.getLatitude(), longitude: newPerson.getLongitude()});
	
};

function onUpdateLocation(data) {
	lat = data.latitude;
	lng = data.longitude;

	var person = personById(this.id);
	person.setLatitude(lat);
	person.setLongitude(lng);

	util.log("Server updated location of "+this.id);
	this.broadcast.emit("update location", {mapId: person.mapId, id: person.id, latitude: person.latitude, longitude: person.longitude});
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