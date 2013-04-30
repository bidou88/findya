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

	client.on("remove person", onRemovePerson);

};

function onClientDisconnect() {

	util.log("Person is disconnected: "+this.id);

	var person = personById(this.id);

	persons.splice(persons.indexOf(person), 1);

	this.broadcast.emit("remove person", {mapId: person.getMapId(), id: person.id, name: person.getName(), latitude: person.getLatitude(), longitude: person.getLongitude()});

};

function onNewPerson(data) {

	var newPerson = new Person(data.mapId, data.name, data.latitude, data.longitude);
	newPerson.id = this.id;

	persons.push(newPerson);

	for (var i = 0; i < persons.length; i++) {
		if(persons[i].getMapId()==data.mapId) {
			this.emit("persons on map", {mapId: persons[i].getMapId(), id: persons[i].id, name: persons[i].getName(), latitude: persons[i].getLatitude(), longitude: persons[i].getLongitude()});
		}
	}

	this.broadcast.emit("new person", {mapId: newPerson.getMapId(), id: newPerson.id, name: newPerson.getName(), latitude: newPerson.getLatitude(), longitude: newPerson.getLongitude()});
	
};

function onRemovePerson(data) {
	

};

function personById(id) {
	for (var i = 0; i < persons.length; i++) {
		if (players[i].id == id)
			return players[i];
	};
	return false;
};

init();