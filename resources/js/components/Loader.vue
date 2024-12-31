<template>
    <div class="m-4 overflow-hidden flex justify-center">
        <div :class="`border-gray-300 h-${height} w-${width} animate-spin rounded-full border-8 border-t-blue-600`"></div>
    </div>
</template>

<script setup>
defineProps({
    height: {
        type: Number,
        default: 25,
    },
    width: {
        type: Number,
        default: 25,
    },
});
</script>
