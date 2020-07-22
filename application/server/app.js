
var express = require("express")
var app = express()
var http = require("http").Server(app)
const { TwingEnvironment, TwingLoaderFilesystem } = require('twing');
let loader = new TwingLoaderFilesystem('./templates');
let twing = new TwingEnvironment(loader);
//var io = require("socket.io")(http)

app.use(express.static("public"))

//app.set('views', './views') // specify the views directory
//app.set("view engine", "pug")

app.get("/", function(req, res) {
  //res.render("index")
  
  twing.render('index.twig', {'name': 'World'}).then((output) => {
    res.end(output);
});
})

app.get("/employee/add", function(req, res) {
  res.render("employee/add")
})
/*
let connected = []

io.on("connection", function(socket) {
  connected.push(socket)
  console.log("A user connected! [ %s sockets online ]", connected.length)
  io.emit("connected", { status: "Connected to the server!" })
  socket.on("disconnect", () => {
    connected.pop()
    console.log("A user disconnected! [ %s sockets online ]", connected.length)
  })
 
})*/

http.listen(3000, function() {
  console.log("listening on *:3000")
})