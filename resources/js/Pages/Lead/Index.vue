<template>
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800">
        <!-- Filter and Actions -->
        <div class="space-y-4">
            <!-- First Line: Filter and Alternative Button -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Lead Tag Filter -->
                <div class="flex gap-2">
                    <select id="leadTags" @change="filter($event)" name="leadTag"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Lead Tag</option>
                        <option v-for="tag in leadTags" :key="tag" :value="tag">{{ tag }}</option>
                    </select>

                    <select id="leadRatings" @change="filter($event)" name="rating"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Lead Rating</option>
                        <option v-for="rating in leadRatings" :key="rating" :value="rating">{{ rating }}</option>
                    </select>

                    <select id="noteStrikeFirst" @change="filter($event)" name="noteStrikeFirst"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Note(Strike First)</option>
                        <option v-for="note in noteStrikeFirst" :key="note" :value="note">{{ note }}</option>
                    </select>

                    <select id="statuses" @change="filter($event)" name="status"
                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="" selected>Select Status</option>
                        <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
                    </select>
                </div>
                <div class="gap-5">
                    <!-- <router-link :to="{name: 'lead.colors'}"
                        class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Lead color
                    </router-link> -->
                    <!-- Alternative Button -->
                    <router-link v-if="roleType != 'client'" :to="{name: 'lead.import'}"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Import Lead
                    </router-link>
                </div>
            </div>
            <!-- Second Line: Show Entries and Search Bar -->
            <div class="flex flex-wrap items-center justify-between">
                <!-- Entries Per Page -->
                <div class="flex items-center space-x-2">
                    <label for="perPage" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Show
                    </label>
                    <select id="perPage" v-model="perPage" @change="pageChange"
                        class="text-sm rounded-lg w-16 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white p-2">
                        <option value="10">10</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Entries</span>
                </div>

                <!-- Search Bar -->
                <div class="relative w-full md:w-64">
                    <input type="search" v-model="search" placeholder="Search..."
                        class="block w-full px-4 py-2 rounded-lg border text-sm text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500" />
                    <svg class="absolute right-3 top-3 h-4 w-4 text-gray-500 dark:text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l-4.35-4.35M10.5 7.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="mt-3 overflow-x-auto">
            <table
                class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700">
                <thead class="border-b-2 border-gray-300">
                    <tr class="bg-gray-2 text-left dark:bg-meta-4 whitespace-nowrap">
                        <th width="40" class="py-4 px-4 font-medium text-black dark:text-white xl:pl-11">
                            #
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white">
                            Name
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white">
                            Phone
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white">
                            State
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white">
                            City
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white">
                            Source
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Lead Tag
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Qualification Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Rating
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Notes (Strike First)
                        </th>
                        <th class="py-4 px-4 bg-gray-200 font-medium text-black dark:text-white xl:pl-11">
                            Start Time
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="serverBusy" class="whitespace-nowrap">
                        <td colspan="13">
                            <Loader />
                        </td>
                    </tr>
                    <tr v-else class="whitespace-nowrap" v-for="(lead, index) in leads" :key="lead">
                        <td class="py-5 px-4 pl-9 xl:pl-11">
                            {{ (pagination.currentPage - 1) * pagination.perPage + index + 1 }}
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.name }}
                            </p>
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.phone }}
                            </p>
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.state }}
                            </p>
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.city }}
                            </p>
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.source }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.lead_tag }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.qualification_status ? 'Qualified' : 'Unqualified' }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.rating }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.note_strike_first }}
                            </p>
                        </td>
                        <td class="py-5 px-4 bg-gray-200">
                            <p class="text-black dark:text-white">
                                {{ lead.start_time }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <p class="text-black dark:text-white">
                                {{ lead.status }}
                            </p>
                        </td>
                        <td class="py-5 px-4">
                            <div class="flex items-center space-x-3.5">
                                <!-- :to="{name: 'lead.update', params: lead.id}" -->
                                <router-link :to="{name: 'lead.update', params: {id: lead.id}}" class="hover:text-primary">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
                                            fill="" />
                                        <path
                                            d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
                                            fill="" />
                                    </svg>
                                </router-link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 text-sm text-gray-700 dark:text-gray-300">
            <div>
                Showing {{ pageData.from }} to {{ pageData.to }} of {{ pageData.total }}
                entries
            </div>
            <Pagination v-if="pagination.lastPage != 1" @refreshTable="createTable"
                :currentPage="pagination.currentPage" :lastPage="pagination.lastPage" :total="pagination.total" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, computed } from "vue";
import Pagination from "@/Components/Pagination.vue";
import HTTP from "../../axios.js";
import { useAuthStore } from "@/stores/auth.js";
const store = useAuthStore();
let roleType = computed(() => store.getUserRole);
import LeadFilters from "@/LeadFilters/filters.js"
import Loader from "@/components/Loader.vue";

const statuses = computed(() => LeadFilters.leadStatus);
const leadTags = computed(() => LeadFilters.leadTags);
const leadRatings = computed(() => LeadFilters.leadRating);
const noteStrikeFirst = computed(() => LeadFilters.leadStrike);

// const props = defineProps({
//     leadTags: Array,
//     leadRatings: Array,
//     noteStrikeFirst: Array,
//     statuses: Array
// });


const searchTimeout = ref(null);
const leads = ref([]);
const search = ref("");
const perPage = ref(10);
const pageData = ref([]);
const queryData = ref({
    page: 1,
    search: "",
    filters: {
        leadTag: "",
        rating: "",
        noteStrikeFirst: "",
        status: ""
    },
});
const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    total: 0,
    perPage: 10,
});

const serverBusy = ref(true);

const setPagination = (response) => {
    pagination.value.total = response.data.meta.total;
    pagination.value.lastPage = response.data.meta.last_page;
    pagination.value.currentPage = response.data.meta.current_page;
};

const createTable = (page) => {
    queryData.value.page = page;
    let endPoint = `${import.meta.env.VITE_API_BASE_URL}leads`;
    HTTP
        .get(endPoint, {
            params: queryData.value,
        })
        .then((response) => {
            serverBusy.value = false;
            leads.value = response.data.data;            
            pageData.value = response.data.meta;
            setPagination(response);
        })
        .catch((error) => { })
        .finally(() => { });
};


const pageChange = (event) => {
    queryData.value.perPage = event.target.value;
    createTable(1);
};

const filter = (event) => {
    queryData.value.filters[event.target.name] = event.target.value;
}

watch(
    [search, () => queryData.value.filters.leadTag, () => queryData.value.filters.rating,
        () => queryData.value.filters.noteStrikeFirst, () => queryData.value.filters.status],
    (newValues, oldValues) => {
        serverBusy.value = true;
        clearTimeout(searchTimeout.value);
        searchTimeout.value = setTimeout(() => {
            queryData.value.search = search.value;
            createTable(1);
            serverBusy.value = false;
        }, 700);
    },
    { immediate: true }
);

onMounted(() => {

});

onUnmounted(() => {
    clearTimeout(searchTimeout.value);
});
</script>
