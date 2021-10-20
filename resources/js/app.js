import "./bootstrap";
import "./_lazy_load_images";
import './components/bookPriceFetcher'
import './components/conversation'
import discussion from "./components/discussion";

document.addEventListener("alpine:init", () => {
    Alpine.data("application", () => ({
        newMessageSound: new Audio(),
        openConversation(user) {
            this.$dispatch('conversation', user);
        },
        init() {
            this.newMessageSound.src = '/sounds/new-message.wav';
        }
    }));
    Alpine.data('discussion', discussion);
});
