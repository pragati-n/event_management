<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .events-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .event-card {
            display: flex;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .event-image img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .event-details {
            flex-grow: 1;
        }

        .event-details h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }

        .event-details .event-date {
            margin: 5px 0;
            color: #888;
            font-size: 14px;
        }

        .event-details .event-description {
            font-size: 16px;
            color: #555;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination button {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #4CAF8C;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .pagination button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="events-container">
        <h1>Upcoming Events</h1>
        <div id="events-list"></div>
        <div class="pagination">
            <button id="prev-btn" disabled>Previous</button>
            <button id="next-btn" disabled>Next</button>
        </div>
    </div>

    <script src="<?=WEB_PATH?>/app/js/jquery-3.7.1.min.js"></script>
    <script src="<?=WEB_PATH?>/app/js/front_script.js"></script>
    <script>
       
    </script>
</body>
</html>
