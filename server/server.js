/**************************************************
** NODE.JS REQUIREMENTS
**************************************************/
var util = require("util"),					// Utility resources (logging, object inspection, etc)
	io = require("socket.io"),				// Socket.IO
	Person = require("./Person").Person;	// Person class


/**************************************************
** VARIABLES
**************************************************/
var socket,		// Socket controller
	persons;	// Array of connected persons


/**************************************************
** INITIALISATION
**************************************************/
function init() {
	// Create an empty array to store persons
	persons = [];

	// Set up Socket.IO to listen on port 8000
	socket = io.listen(8000);

	// Configure Socket.IO
	socket.configure(function() {
		// Only use WebSockets
		socket.set("transports", ["websocket"]);

		// Restrict log output
		socket.set("log level", 2);
	});

	// Start listening for events
	setEventHandlers();
};


/**************************************************
** EVENT HANDLERS
**************************************************/
var setEventHandlers = function() {
	// Socket.IO
	socket.sockets.on("connection", onSocketConnection);
};

// New socket connection
function onSocketConnection(client) {
	
	util.log("New persons has connected: "+client.id);

	// Listen for client disconnected
	client.on("disconnect", onClientDisconnect);

	// Listen for new player message
	client.on("new person", onNewPerson);

	// Listen for move player message
	client.on("remove person", onRemovePerson);
};

// Socket client has disconnected
function onClientDisconnect() {
	util.log("persons has disconnected: "+this.id);

	var removePerson = personById(this.id);

	// Player not found
	if (!removePerson) {
		util.log("persons not found: "+this.id);
		return;
	};

	// Remove player from players array
	persons.splice(persons.indexOf(removePerson), 1);

	// Broadcast removed player to connected socket clients
	this.broadcast.emit("remove person", {id: this.id});
};

// New player has joined
function onNewPerson(data) {
	util.log(data.name);
	this.broadcast.emit("new person", {});
};

// New player has joined
function onRemovePerson(data) {
	

};

/*
// Player has moved
function onMovePlayer(data) {
	// Find player in array
	var movePlayer = playerById(this.id);

	// Player not found
	if (!movePlayer) {
		util.log("Player not found: "+this.id);
		return;
	};

	// Update player position
	movePlayer.setX(data.x);
	movePlayer.setY(data.y);

	// Broadcast updated position to connected socket clients
	this.broadcast.emit("move player", {id: movePlayer.id, x: movePlayer.getX(), y: movePlayer.getY()});
};
*/

/**************************************************
** GAME HELPER FUNCTIONS
**************************************************/
// Find player by ID
function personById(id) {
	var i;
	for (i = 0; i < persons.length; i++) {
		if (persons[i].id == id)
			return persons[i];
	};

	return false;
};


/**************************************************
** RUN THE GAME
**************************************************/
init();