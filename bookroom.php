<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewpore" content="width=device-width, initial-scale=1.0">
        <title> IT College</title>
        
        <script type="text/javascript">
          function preventBack(){window.history.forward()};
          setTimeout("preventBack()",0);
          window.onunload=function(){null;}
          </script>
        
        <link rel="stylesheet" href="bookingc.css">
    </head>
    <body>
        <!--Book Room-->
     
    <div class="background">
   <div class="booking-form">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
        <h2>Book The Room</h2>
       
        <form action="bookingdata.php" method="post">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required>

                    <label for="name">Email</label>
                    <input type="email" name="email" id="email" required>

                    
                  

                    <button type="submit">Book Now</button>
                   
                    <a href="roomtable.php">Back</a>

                </form>
            </div>
        </div>
    </div>
    </body>


