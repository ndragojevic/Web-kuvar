<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

    <link rel="stylesheet" href="login.css">

    <!--<script src="login.js"></script>-->

        <title>Web kuvar</title>

       
    </head>

    <body >
        <div id="prva"  > <!--id?-->
                <table>
                    <tr>
                      <form action="{{ route('index') }}" method="GET">
                            @csrf<button class="btnn" onclick=""> Pocetak</button></form>
                    
                    </tr>
                </table>
          
        </div>

        <div id="divimg">
            <h1 id="header"><br>Web Kuvar</h1>    
        </div>


    
    <form name="loginform" action="{{ route('login_submit') }}" method="POST">
        @csrf

        <div class="form-group" style="text-align: center;">

            <div class="form-group">
                <label for="korime" style="color:white">Korisničko ime</label><br>
                <center>
                <input type="text" id="korime" name="korime" value="{{old('korime')}}" 
                    placeholder="Korisnicko ime" size="50" style="border-radius: 5px;"><br>
                </center>
                <td> @error('korime')  <font color='red'> {{ $message }} </font>
                @enderror</td>
            </div>

            <div class="form-group">
                <label for="lozinka" style="color:white">Lozinka</label><br>
                <center>
                <input type="password" id="lozinka" name="lozinka" 
                    placeholder="Lozinka" size="50" style="border-radius: 5px;"><br>
                </center>
                <td> @error('lozinka') <font color='red'> {{ $message }} </font>
                @enderror </td>
            </div>

            <button type="submit" class="btn btn-primary btn-success">
                Prijava
            </button>
        </div>
    </form>

    <center>
        @if (session('status'))
        <font color='red'>{{session('status')}}</font>
        @endif
    </center>
    
    </body>
</html>

<style>

body {
    background: rgb(26, 25, 25);
}
#header{
    color:rgb(245, 242, 242);
    margin-top: 10px;
    text-align:center;
    font-family: 'Raleway',Helvetica,Arial,Lucida,sans-serif;
    text-shadow: 0.08em 0.08em 0em rgb( 200 200 200 / 40%);
    font-weight: 400;
    font-size: 3vw;
}
.slika{
    width: 70px;
    height: 65px;
}
#divh{
    height: 60px;
    background: rgb(26, 25, 25);
    width: 100%;
}
    
#divimg{
    height: 150px;
    background: white;
    width: 100%;

    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/img/p.jpg');


  /* Position and center the image to scale nicely on all screens */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  position: relative;
  margin-top: 10px;
  text-align: center;
}
#imgdiv{
    height: 60px;
   width: 60px;
}
#prva{
    background: rgb(241, 83, 15);
    height: 70px;
   text-align: left;
   color:white;
}
.btnn{
    background: rgb(241, 83, 15);
    font-size: 20px;
    color:rgb(70, 69, 69);
    border: 0px;
    width: 200px;
    margin-top: 17px;
  
}
.center {
  display: flex;
  justify-content: center;
  margin-top: 5%;
}

.card-img-top {
  height: 15%;
}

.space {
  display: flex;
  justify-content: space-between;
}
.para{
    color:white;
    height: 300px;
    width:500px;
    margin-left: 15px;

}

table {
  margin: 7px;
  width: min-content;
  height: min-content;
}
.korisnik {
  font-weight: bold;
  color: steelblue;
  font-style: italic;
}

.date {
  font-style: italic;
  font-size: small;
}

.grade {
  justify-content: space-around;
}

.checked {
  color: #f3da35;
}

.card {
  height: auto;
}
</style>