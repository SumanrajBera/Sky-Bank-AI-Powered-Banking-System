const {PythonShell} = require("python-shell");
var mes = document.getElementById("txt");


let options = {
    scriptPath: "D:/Practice dev/JS",
    args: [mes]
};
function clicked(){
    PythonShell.run("check.py",options).then(messages=>{
        var msg = messages.toString()
        document.getElementById("response").innerHTML = msg;
      }); 
}
var http = require('http');

http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    res.end('Hello World!');
}).listen(5500);
