<template>
    <div class="max-w-md mx-auto mt-5">
        <input 
            v-model="searchQuery" 
            @input="debounceSearch" 
            placeholder="Search users..." 
            class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        
        <!-- Loading State -->
        <div v-if="loading" class="mt-2 text-center text-gray-600">
            Loading...
        </div>

        <!-- Error State -->
        <div v-if="error" class="mt-2 text-center text-red-600">
            {{ error }}
        </div>

        <!-- Results -->
        <ul v-if="users.length > 0" class="mt-2 bg-white border border-gray-300 rounded-md shadow-md">
            <li 
                v-for="user in users" 
                :key="user.id" 
                @click="selectUser(user)"
                class="p-2 hover:bg-gray-100 cursor-pointer flex items-center justify-between"
            >
                <span>{{ user.first_name }} {{ user.last_name }}</span>
                <span class="text-sm text-gray-500">{{ user.email }}</span>
            </li>
        </ul>

        <!-- No Results -->
        <div v-else-if="searchQuery && !loading" class="mt-2 text-center text-gray-600">
            No users found
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { debounce } from 'lodash'; // Add this import

export default {
    name: 'UserSearch',
    data() {
        return {
            searchQuery: '',
            users: [],
            loading: false,
            error: null,
        };
    },
    created() {
        // Create debounced version of search function
        this.debounceSearch = debounce(this.searchUsers, 300);
    },
    methods: {
        async searchUsers() {
            if (!this.searchQuery.trim()) {
                this.users = [];
                return;
            }

            try {
                this.loading = true;
                this.error = null;

                const response = await axios.get('/api/users/search', {
                    params: { query: this.searchQuery.trim() },
                });
                
                this.users = response.data;
            } catch (err) {
                this.error = 'An error occurred while searching users';
                console.error('Search error:', err);
                this.users = [];
            } finally {
                this.loading = false;
            }
        },
        selectUser(user) {
            // Emit event when user is selected
            this.$emit('user-selected', user);
            // Optionally clear the search
            // this.searchQuery = '';
            // this.users = [];
        }
    },
    // Clean up debounce on component destroy
    beforeUnmount() {
        this.debounceSearch.cancel();
    }
};
</script>

<style scoped>
.user-search-input {
    transition: all 0.3s ease;
}

.user-search-input:focus {
    transform: translateY(-1px);
}

/* Add any additional custom styles here */
</style>