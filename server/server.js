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
	
	util.log("Person has connected: "+client.id);

	client.on("disconnect", onClientDisconnect);

	client.on("new person", onNewPerson);

	client.on("remove person", onRemovePerson);

};

function onClientDisconnect() {

	util.log("Person has disconnected: "+this.id);

};

function onNewPerson(data) {

	var newPerson = new Person(data.mapId, data.name, data.latitude, data.longitude);
	newPerson.id = this.id;

	persons.push(newPerson);

	for (var i = 0; i < persons.length; i++) {
		if(persons[i].getMapId()==data.mapId) {
			this.emit("new person", {mapId: persons[i].mapId, id: persons[i].id, name: persons[i].getName(), latitude: persons[i].getLatitude(), longitude: persons[i].getLongitude()});
		}
	}

	util.log("new person > mapId: " +data.mapId+ " id: " +newPerson.id+ " name: " +newPerson.getName()+ " latitude: " +newPerson.getLatitude()+ " longitude: " +newPerson.getLongitude());
	this.broadcast.emit("new person", {mapId: data.mapId, id: newPerson.id, name: newPerson.getName(), latitude: newPerson.getLatitude(), longitude: newPerson.getLongitude()});

	
};

// New player has joined
function onRemovePerson(data) {
	

};

init();