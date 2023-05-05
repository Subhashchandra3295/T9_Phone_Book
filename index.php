<!DOCTYPE html>
<html>
<head>
  <title>T9 Phone Book</title>
</head>
<body>
  <h1>T9 Phone Book</h1>

  <h2>Create New Entry</h2>

  <form method="post" action="controller.php">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" required>

    <br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" required>

    <br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" name="phone_number" required>

    <br><br>

    <input type="submit" name="addcontact" value="Add Contact">
  </form>

  <hr>

  <h2>Search Entries</h2>

  <form method="get" action="controller.php">
    <label for="numbers">Numbers:</label>
    <input type="text" name="numbers" required>

    <br><br>

    <input type="submit" name="search" value="Search">
    <input type="submit" name="clear" value="reset">
  </form>
</body>
</html>
