var express = require("express");
var app = express();
var server = require("http").createServer(app);
var io = require("socket.io")(server);

var users = [];
var connections = [];

server.listen(process.env.PORT || 2020);
console.log("Chat is up and running");

app.get("/", function (req, res) {
	res.sendFile(__dirname + "/chat.html");
});

io.sockets.on("connection", function (socket) {
	connections.push(socket);
	io.sockets.emit("new user");
	console.log("Users connected: %s", connections.length);

	socket.on("disconnect", function (data) {
		users.splice(users.indexOf(socket.username), 1);
		io.sockets.emit("user left");

		connections.splice(connections.indexOf(socket), 1);
		console.log("User disconnected: %s ", connections.length);
	});

	socket.on("send message", function (data, name) {
		console.log(data);
		io.sockets.emit("new message", { msg: data, sender: name});
	});
});
