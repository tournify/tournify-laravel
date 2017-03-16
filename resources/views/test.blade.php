
    <p id="registered"></p>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="{{ asset('/javascript/socket.io.js') }}"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://turnering.io:3000');
        socket.on("main:App\\Events\\UserRegistered", function(message){
            // increase the power everytime we load test route
            console.log(message);
            $('#registered').text(message.user.name + " " + message.user.email);
        });
    </script>