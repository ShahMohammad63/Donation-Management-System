<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Streamlined Charity Fundraising Assistant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 150px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 20px;
        }
        .button-group a {
			flex: 1;
			padding: 12px;
			border: none;
			border-radius: 4px;
			background-color: #333;
			color: #fff;
			text-decoration: none;
			font-size: 15px;
			cursor: pointer;
			transition: background-color 0.3s;
			text-align: center;

			display: flex;
			justify-content: center;
			align-items: center; /* Vertically center text */
			height: 50px; /* Optional: for consistent height */
		}
        .button-group a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Choose Registration Type</h2>
        <div class="button-group">
            <a href="donor_registration.php">Register as Donor</a>
            <a href="organization_registration.php">Register as Organization</a>
        </div>
    </div>
</body>
</html>