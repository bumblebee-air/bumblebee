var app = require('express')();

var https = require('https');
var fs = require('fs');
var options = {
    key: fs.readFileSync('/etc/ssl/private/admin.doorder.eu.key'),
    cert: fs.readFileSync('/etc/ssl/certs/admin_doorder_eu.crt')
};

var server = https.createServer(options, app);

var io = require('socket.io')(server, {
    cors: {
        origin: '*',
    }
});
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
