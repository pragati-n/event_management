let currentPage = 1;
const limit = 5;

function loadEvents(page) {
   
    $.ajax({
        url: '/events-management/index.php/api/upcoming_events',
        type: 'GET',
        data: { page: page, limit: limit }, // Use regular object, not JSON.stringify
        success: function(response) {
            console.log('response');
            console.log(response);
            const eventsList = $('#events-list'); // Use jQuery to select the element
            eventsList.empty(); // Clear the current list
            
            if (response.success) {
                console.log('innnresponse');
                const eventsData = response.data; // Access the events data
                console.log('events111');
                console.log(eventsData);
                const events = eventsData['events ']; // Access the events array
                if (Array.isArray(events)) {
                    events.forEach(function(event) {
                        // Process each event here
                        ev_date = formatEventDate(event.event_date);
                        const eventCard = `
                            <div class="event-card">
                                <div class="event-image">
                                <img src="http://localhost/events-management/${event.image_path}" alt="${event.event_name}">
                                </div>
                                <div class="event-details">
                                    <h3>${event.event_name}</h3>
                                    <p class="event-date">Date: ${ev_date}</p>
                                    <p class="event-description">${(event.even_description).substring(0,200)}...</p>
                                </div>
                            </div>
                        `;
                        eventsList.append(eventCard); // Use jQuery's append method
                    });
                }
                
                // Update pagination buttons
                    const prevBtn = $('#prev-btn');
                    const nextBtn = $('#next-btn');

                    const totalEvents = response.data.total_events;//response.total_events;
                    
                    const totalPages = Math.ceil(totalEvents / limit);
                   
                    prevBtn.prop('disabled', currentPage <= 1);
                    nextBtn.prop('disabled', currentPage >= totalPages);
            }

            
        },
        error: function(error) {
            console.error('Error loading events:', error);
        }
    });
}

$('#prev-btn').on('click', () => {
    if (currentPage > 1) {
        currentPage--;
        loadEvents(currentPage);
    }
});

$('#next-btn').on('click', () => {
    currentPage++;
    loadEvents(currentPage);
});

// Load initial set of events
loadEvents(currentPage);


function formatEventDate(dateString) {
    const date = new Date(dateString);
    
    // Options for date formatting
    const optionsDate = { day: '2-digit', month: '2-digit', year: 'numeric' };
    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: true };

    const formattedDate = date.toLocaleDateString('en-GB', optionsDate); // "DD/MM/YYYY"
    const formattedTime = date.toLocaleTimeString('en-GB', optionsTime); // "HH:mm AM/PM"

    return `${formattedDate} ${formattedTime}`;
}