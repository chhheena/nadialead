<script setup>
    import { ref } from 'vue';
    import ApplicationLogo from '@/Components/ApplicationLogo.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
    import NavLink from '@/Components/NavLink.vue';
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
    import { Link } from '@inertiajs/vue3';
    import HeaderArea from '@/components/Header/HeaderArea.vue';
    import SidebarArea from '@/components/Sidebar/SidebarArea.vue';
    const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="flex h-screen overflow-hidden">

      <SidebarArea />

      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

        <HeaderArea />

        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- <slot></slot> -->
             <router-view></router-view>
          </div>
        </main>

      </div>
    </div>
</template>
