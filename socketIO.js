var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
console.log('Server is running.....');
io.on('connection', function (socket) {

    console.log("new client connected");
    var redisClient = redis.createClient();
    redisClient.subscribe('doorder-channel');

    redisClient.on("message", function(channel, data) {
        let decodedData = JSON.parse(data)
        socket.emit(channel + ':' + decodedData.event, data);
        console.log(data)
    });

    socket.on('disconnect', function() {
        redisClient.quit();
    });
});
