<template>
  <authenticated-layout>
    <template #header>
      <div class="flex justify-between gap-4">
        <h1 class="text-2xl font-bold">
          Courses
        </h1>
        <NavLink :href="route('course.create')">Create Course</NavLink>
      </div>
    </template>
    <section class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <ul v-if="courses.length">
        <li v-for="course in courses" :key="course.id">
          {{ course.code }}
        </li>
      </ul>
      <p v-else>
        You have no courses.
        <NavLink :href="route('course.create')">Create Course</NavLink>
      </p>

    </section>
  </authenticated-layout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";

defineProps<{
  courses: any[]
}>();
</script>