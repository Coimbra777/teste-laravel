<script>
export default {
  props: {
    user: String
  }
};
</script>

<template>
    <div>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
      <div class="py-12">Hello, {{ user }}</div>
    </div>
  </template>
  