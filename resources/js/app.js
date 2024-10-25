import { createApp } from 'vue';
import Welcome from './components/Welcome.vue'; // Ensure the path is correct

const app = createApp({});

// Register the Welcome component
app.component('welcome-component', Welcome);

// Mount the app
app.mount('#app');

