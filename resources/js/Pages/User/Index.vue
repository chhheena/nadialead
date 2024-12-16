<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div
      class="rounded-lg border border-gray-200 bg-white p-6 shadow-lg dark:border-gray-700 dark:bg-gray-800"
    >
      <!-- Filter and Actions -->
      <div class="space-y-4">
        <!-- First Line: Filter and Alternative Button -->
        <div class="flex flex-wrap items-center justify-between">
          <!-- Course Filter -->
          <select
            @change="changeFilter($event)"
            id="course"
            class="block w-full lg:w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          >
            <option selected disabled>Select Role</option>
            <option value="client">Client</option>
            <option value="team">Team</option>
          </select>

          <!-- Alternative Button -->
          <Link :href="route('user.add-edit')"
            class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            Add User
          </Link>
        </div>

        <!-- Second Line: Show Entries and Search Bar -->
        <div class="flex flex-wrap items-center justify-between">
          <!-- Entries Per Page -->
          <div class="flex items-center space-x-2">
            <label
              for="perPage"
              class="text-sm font-medium text-gray-700 dark:text-gray-300"
            >
              Show
            </label>
            <select
              id="perPage"
              v-model="perPage"
              @change="pageChange"
              class="text-sm rounded-lg w-16 border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white p-2"
            >
              <option value="10">10</option>
              <option value="30">30</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
            <span class="text-sm text-gray-600 dark:text-gray-400">Entries</span>
          </div>

          <!-- Search Bar -->
          <div class="relative w-full md:w-64">
            <input
              type="search"
              v-model="search"
              placeholder="Search..."
              class="block w-full px-4 py-2 rounded-lg border text-sm text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700 border-gray-300 dark:border-gray-600 focus:ring-blue-500 focus:border-blue-500"
            />
            <svg
              class="absolute right-3 top-3 h-4 w-4 text-gray-500 dark:text-gray-400"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 15l-4.35-4.35M10.5 7.5a3 3 0 11-6 0 3 3 0 016 0z"
              />
            </svg>
          </div>
        </div>
      </div>

      <!-- Table Section -->
      <div class="mt-2 overflow-x-auto">
        <table
          class="w-full min-w-full border-collapse border border-gray-200 rounded-lg shadow-md dark:border-gray-700"
        >
          <thead class="bg-blue-500">
            <tr>
              <th class="px-4 py-2 text-left text-sm font-semibold text-white">#</th>
              <th class="px-4 py-2 text-left text-sm font-semibold text-white">Name</th>
              <th class="px-4 py-2 text-left text-sm font-semibold text-white">Email</th>
              <th class="px-4 py-2 text-center text-sm font-semibold text-white">
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(user, index) in users"
              :key="user"
              class="border-t last:border-b hover:bg-gray-50 dark:hover:bg-gray-700"
            >
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                {{ (pagination.currentPage - 1) * pagination.perPage + index + 1 }}
              </td>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                {{ user.name }}
              </td>
              <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                {{ user.email }}
              </td>
              <td class="px-4 py-3 text-center">
                <div class="inline-flex space-x-4">
                  <!-- Edit Button -->
                  <Link
                    class="px-3 py-1.5 rounded-lg text-sm text-blue-600 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-600 hover:text-blue-800 dark:hover:text-white"
                    :href="route('user.add-edit', user.id)"
                  >
                    Edit
                  </Link>
                  <!-- Delete Button -->
                  <button
                    class="px-3 py-1.5 rounded-lg text-sm text-red-600 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-600 hover:text-red-800 dark:hover:text-white"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div
        class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 text-sm text-gray-700 dark:text-gray-300"
      >
        <div>
          Showing {{ pageData.from }} to {{ pageData.to }} of {{ pageData.total }}
          entries
        </div>
        <Pagination
          v-if="pagination.lastPage != 1"
          @refreshTable="createTable"
          :currentPage="pagination.currentPage"
          :lastPage="pagination.lastPage"
          :total="pagination.total"
        />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, provide } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { useAppStore } from "@/stores";
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue";
import axios from "axios";
import { Link } from "@inertiajs/vue3";

const appStore = useAppStore();
provide("appStore", appStore);

const searchTimeout = ref(null);
const users = ref([]);
const search = ref("");
const perPage = ref(10);
const pageData = ref([]);
const queryData = ref({
  isRestore: "",
  page: 1,
  search: "",
});
const pagination = ref({
  currentPage: 1,
  lastPage: 1,
  total: 0,
  perPage: 10,
});

const setPagination = (response) => {
  pagination.value.total = response.data.meta.total;
  pagination.value.lastPage = response.data.meta.last_page;
  pagination.value.currentPage = response.data.meta.current_page;
};

const createTable = (page) => {
  queryData.value.page = page;
  axios
    .get(route("users.index"), {
      params: queryData.value,
    })
    .then((response) => {
      users.value = response.data.data;
      pageData.value = response.data.meta;
      setPagination(response);
    })
    .catch((error) => {})
    .finally(() => {});
};


const pageChange = (event) => {
  queryData.value.perPage = event.target.value;
  createTable(1);
};

watch(search, (value) => {
  clearTimeout(searchTimeout.value);
  searchTimeout.value = setTimeout(() => {
    queryData.value.search = value;
    createTable();
  }, 700);
});

const changeFilter = (e) => {
  queryData.value.role = e.target.value;
  createTable();
};

onMounted(() => {
  createTable(1);
});

onUnmounted(() => {
  clearTimeout(searchTimeout.value);
});
</script>
