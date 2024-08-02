<template>
  <div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
    <h1 class="text-2xl font-bold">{{ title }}</h1>
    <p>{{ description }}</p>
    <button class="btn btn-blue">Click me</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      title: 'Hello World',
      description: 'This is a description',
    };
  },
};
</script>

<style scoped>
/* Any scoped styles */
</style>
