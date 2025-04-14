<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SSRF Lab - Fetch URL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 40px;
        }
        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            font-size: 15px;
            background-color: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .response-box {
            margin-top: 30px;
            background-color: #f9f9f9;
            border-left: 6px solid #007bff;
            padding: 20px;
            white-space: pre-wrap;
            font-family: monospace;
            color: #333;
            max-height: 500px;
            overflow: auto;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🧪 SSRF Lab – Server-Side Request Forgery</h2>
        <form method="get">
            <label for="url">Enter a URL to fetch:</label>
            <input type="text" name="url" id="url" placeholder="http://localhost/" value="<?php echo isset($_GET['url']) ? htmlspecialchars($_GET['url']) : '' ?>">
            <button type="submit">Fetch</button>
        </form>

        <?php
        if (isset($_GET['url']) && filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
            echo "<div class='response-box'><strong>Response from: " . htmlspecialchars($_GET['url']) . "</strong><br><br>";
            $url = $_GET['url'];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo "Error: " . curl_error($ch);
            } else {
                echo htmlspecialchars($response);
            }

            curl_close($ch);
            echo "</div>";
        } elseif (isset($_GET['url'])) {
            echo "<p style='color: red;'>❌ Invalid URL</p>";
        }
        ?>
    </div>
</body>
</html>
