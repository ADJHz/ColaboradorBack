const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: {
        origin: 'http://localhost:4200',
        credentials: true
    }
});
const port = 3000;

io.on('connection', (socket) => {
    console.log('Nuevo cliente conectado:', socket.id);

    socket.on('disconnect', () => {
        console.log('Cliente desconectado:', socket.id);
    });
});

app.use(require('express').json());

app.post('/notify', (req, res) => {
    const { event, data } = req.body;
    console.log(`Evento recibido: ${event}`);
    io.emit(event, data);
    res.status(200).send('Notification sent');
});

server.listen(port, () => {
    console.log(`Socket.io server running on port ${port}`);
});
