<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="mb-3 block text-sm font-medium text-black dark:text-white">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
