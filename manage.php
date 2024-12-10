<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manageroom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Rooms</title>
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
                <li class="navList active">
                    <a href="managetable.php">
                    <i class="fa-solid fa-file fa-lg" style="color: #ffffff; margin: 10px;"></i>
                        <span class="links">Manage Table</span>
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


            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id" placeholder="Enter Your User ID" required>


            <label for="equipment">Equipment</label>
            <select id="equipment" name="equipment">
                <option value="switch">Switch</option>
                <option value="router">Router</option>
                <option value="computer">Computer</option>
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
            <select id="new_equipment" name="new_equiemnet">
            <option value="computer">computer</option>
            <option value="router">router</option>
            <option value="switch">switch</option>

            </select>

            <label>Edited by</label>
            <input type="number" id="new_user_id" name="new_user_id" placeholder="Edited by">


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
