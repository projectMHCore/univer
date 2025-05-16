var express = require("express");
var app = express();

var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('public'));

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/public/index.html');
});

io.on('connection', function(socket){
  console.log('a user connected');
  
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
  
  socket.on('send message', function(msg) {
    io.emit('receive message', msg);
  });
});

http.listen(3000, function() {
  console.log('listening on *:3000');
});
