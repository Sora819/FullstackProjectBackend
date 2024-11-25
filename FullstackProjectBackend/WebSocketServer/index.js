import { getLyrics, getSong, getSongById } from 'genius-lyrics-api';
import { WebSocketServer } from 'ws';

const wss = new WebSocketServer({ port: 8080 });

console.log('Started server, listening on port: ' + wss.address().port);

wss.on('connection', function connection(ws) {
  ws.on('message', function message(data) {
    data = data.toString();
    data = data.split(';');

    switch (data[0]) {
        case 'Get-Lyrics':
            console.log('Get-Lyrics');

            getSongById(data[1], data[2]).then((song) => {
                console.log(song.lyrics);
                ws.send(song.lyrics);
            })
            break;

        case 'Get-Song':
            console.log('Get-Song');

            getSong({
                apiKey: data[2],
                title: data[1],
                artist: ' '
            }).then((song) => {
                console.log(song.id);
                ws.send(song.id);
            })
            break;
        default:
            break;
    }
  });
});