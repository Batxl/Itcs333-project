<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Rooms</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    width: 100%;
    background-color: #f4f3ee;
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
}

nav {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px;
    background-color: #274C77;
    padding: 20px 10px;
    display: flex;
    flex-direction: column;
    align-items: start;
}

nav .menu-items {
    margin-top: 30px;
    list-style: none;
}

nav .menu-items li {
    margin-bottom: 20px;
}

nav .menu-items li a {
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 25px;
    transition: background-color 0.3s;
}

.dashboard {
    margin-left: 250px;
    padding: 40px;
    background-color: #f4f3ee;
    min-height: 100vh;
}

.manage-rooms-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: #E7ECEF;
    border-radius: 12px;
    color: #274C77;
}

.form-section {
    margin-bottom: 40px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    color: #274C77;
}

.form-section h2 {
    font-size: 24px;
    font-weight: 600;
    color: #274C77; 
    margin-bottom: 20px;
    border-bottom: 2px solid #274C77;
    padding-bottom: 10px;
}

.form-section form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #6096BA; 
}

.form-section form input,
.form-section form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #f9f9f9;
}

.form-section form input:focus,
.form-section form select:focus {
    border-color: #274C77; 
    outline: none;
}

.form-section form button {
    width: 100%;
    padding: 12px;
    background-color: #A3CEF1; 
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: 600;
}

.form-section form button:hover {
    background-color: #A3CEF1;
    color: #6096BA;
}

        </style>
</head>
<body>
    <nav>
        <div class="menu-items">
            <ul class="navLinks">
                <li class="navList">
                    <a href="admin-dashboard.php">
                    <i class="fa-solid fa-house fa-lg" style="color: #ffffff; margin: 5px;"></i>
                        <span class="links">Dashboard</span>
                    </a>
                </li>
                <li class="navList active">
                    <a href="manage.php">
                    <i class="fa-solid fa-file fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Manage Rooms</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
    <div class="manage-rooms-container">
    <!-- Add Room -->
    <div class="form-section">
        <h2>Add Room</h2>
        <form action="addroom.php" method="POST">

            <label for="room_id">Room ID</label>
            <input type="text" id="room_id" name="room_id" placeholder="Enter Room ID" required>

            <label for="capacity">Capacity</label>
            <input type="number" id="capacity" name="capacity" placeholder="Enter Room Capacity" required>


            <label for="type">Type</label>
            <select id="type" name="type" required>
                <option value="Lab">Lab</option>
                <option value="Class">Class</option>
            </select>


            <label for="equipment">Equipment</label>
            <select id="equipment" name="equipment">
                <option value="None">None</option>
                <option value="Switch">Switch</option>
                <option value="Router">Router</option>
                <option value="Computer">Computer</option>
            </select>

            <button type="submit">Add Room</button>
        </form>
    </div>
          

        <!-- Edit Room -->
        <div class="form-section">
            <h2>Edit Room</h2>
            <form action="editroom.php" method="POST">
            <label for="old_id">Old Room ID</label>
            <input type="text" id="old_id" name="old_id" placeholder="Enter the current Room ID" required>

            <label for="new_id">New Room ID</label>
            <input type="text" id="new_id" name="new_id" placeholder="Enter the new Room ID">

            <label for="new_capacity">Room Capacity</label>
            <input type="number" id="new_capacity" name="new_capacity" placeholder="Enter new capacity">

            <label for="new_type">Room Type</label>
             <select id="new_type" name="new_type">
                <option value="Lab">Lab</option>
                <option value="Class">Class</option>
            </select>

            <label>Equipment</label>
            <select id="new_equipment" name="new_equipment">
            <option value="None">None</option>
            <option value="Computer">Computer</option>
            <option value="Router">router</option>
            <option value="Switch">switch</option>

            </select>


        <button type="submit">Submit Changes</button>
    </form>
</div>


            <!-- Delete Room -->
            <div class="form-section">
                <h2>Delete Room</h2>
                <form action="deleteroom.php" method="POST">
                    <label for="delete-room-id">Room ID:</label>
                    <input type="text" id="delete-room-id" name="room_id" placeholder="Enter Room ID to Delete" required>

                    <button type="submit">Delete Room</button>
                </form>
            </div>
        </div>
</section>
</body>
</html>