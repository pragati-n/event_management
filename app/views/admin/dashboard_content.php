<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h2>Upcoming Events</h2>
    
</head>
<body>
    <div class="events-container">
       
        <div id="events-list"></div>
        <div class="pagination">
            <button id="prev-btn" disabled>Previous</button>
            <button id="next-btn" disabled>Next</button>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const token = 'your_jwt_token_here'; // Replace with your actual token

    let currentPage = 1;
    const limit = 5;

    function loadEvents(page) {
        $.ajax({
            url: `your_api_url_here?page=${page}&limit=${limit}`,
            type: 'GET',
            headers: {
                "Authorization": `Bearer ${token}`
            },
            success: function(response) {
                const eventsList = document.getElementById('events-list');
                eventsList.innerHTML = ''; // Clear the current list

                response.events.forEach(event => {
                    const eventCard = `
                        <div class="event-card">
                            <div class="event-image">
                                <img src="${event.image}" alt="${event.name}">
                            </div>
                            <div class="event-details">
                                <h3>${event.name}</h3>
                                <p class="event-date">Date: ${event.date}</p>
                                <p class="event-description">${event.description}</p>
                            </div>
                        </div>
                    `;
                    eventsList.insertAdjacentHTML('beforeend', eventCard);
                });

                // Update pagination buttons
                const prevBtn = document.getElementById('prev-btn');
                const nextBtn = document.getElementById('next-btn');

                prevBtn.disabled = currentPage <= 1;
                nextBtn.disabled = currentPage >= Math.ceil(response.total / limit);
            }
        });
    }

    document.getElementById('prev-btn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            loadEvents(currentPage);
        }
    });

    document.getElementById('next-btn').addEventListener('click', () => {
        currentPage++;
        loadEvents(currentPage);
    });

    // Load initial set of events
    loadEvents(currentPage);
</script>
</html>
