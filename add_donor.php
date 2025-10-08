<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Donor</title>
</head>
<body>

<h2>Add Donor (Admin Panel)</h2>

<form action="process_donor.php" method="POST">
    <input type="hidden" name="source" value="admin">

    <label for="name">Full Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="date_of_birth">Date of Birth:</label><br>
    <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>

    <label for="gender">Gender:</label><br>
    <select id="gender" name="gender" required>
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br><br>

    <label for="address">Address:</label><br>
    <textarea id="address" name="address" required></textarea><br><br>

    <label for="email">Email Address:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="blood_group">Blood Group:</label><br>
    <input type="text" id="blood_group" name="blood_group" required><br><br>

    <label for="profession">Profession:</label><br>
    <input type="text" id="profession" name="profession" required><br><br>

    <button type="submit">Add Donor</button>
</form>

</body>
</html>