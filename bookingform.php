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
        
    <div class="background">
   <div class="booking-form">
    <div class="col-lg-12 bg-white shadow p-4 rounded">
        <h2>Check Booking Availability</h2>
       
        <form action="bookdate.php" method="post">
                    <!--<label for="name">Room id</label>
                    <input type="int" name="room_id" id="room_id" required>-->

                    <label for="name">Booking date</label>
                    <input type="datetime-local" name="reservation_date" id="reservation_date" required>

                    
                  

                    <button type="submit" a href="bookdate">Book Now</button>
                   
                    <a href="Main page.php">Back</a>

                </form>
            </div>
        </div>
    </div>
    </body>






