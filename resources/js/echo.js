import Echo from "laravel-echo";
import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    authEndpoint: "/broadcasting/auth",
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.Echo.channel("tickets").listen(".UpdateTicketsCount", (e) => {
    console.log("Ticket update received:", e);

    const ticketElement = document.querySelector(
        `[data-ticket-id="${e.ticket.id}"] .available-count`
    );

    console.log(ticketElement); // چاپ ticketElement برای دیباگ

    if (ticketElement) {
        ticketElement.textContent = e.ticket.available_count;
    } else {
        console.error("Ticket element not found for ID:", e.ticket.id);
    }
    sessionStorage.setItem('ticketUpdate', JSON.stringify(e));
});
