<template>
    <input
        @change="fileChange"
        type="file"
        class="inline-flex items-center rounded-md border border-transparent bg-purple-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-purple-700 focus:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 active:bg-purple-900"
    />
</template>

<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    type: File,
    required: false,
});

const fileInput = ref(null);

defineExpose({ focus: () => fileInput.value.focus() });
function fileChange(event) {
    model.value = event.target.files[0];
}
</script>
