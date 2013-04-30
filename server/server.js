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

	var mapId = data.mapId;
	var newPerson = new Person(data.name, data.latitude, data.longitude);
	newPerson.id = this.id;

	util.log("new person > mapId: " +mapId+ " id: " +newPerson.id+ " name: " +newPerson.getName()+ " latitude: " +newPerson.getLatitude()+ " longitude: " +newPerson.getLongitude());
	this.emit("new person", {mapId: mapId, id: newPerson.id, name: newPerson.getName(), latitude: newPerson.getLatitude(), longitude: newPerson.getLongitude()});

};

// New player has joined
function onRemovePerson(data) {
	

};

init();