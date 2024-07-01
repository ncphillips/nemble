<template>
  <authenticated-layout>
    <template #header>
      <h1 class="text-2xl font-bold">
        Create Courses
      </h1>
    </template>
    <section class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <form
        @submit.prevent="form.post(route('course.store'))"
        class="flex flex-col gap-3">
        <label class="flex flex-col gap-2">
          <span>name</span>
          <input v-model="form.name" />
          <span v-if="form.errors.name">{{ form.errors.name}}</span>
        </labeL>
        <label class="flex flex-col gap-2">
          <span>code</span>
          <input v-model="form.code" />
          <span v-if="form.errors.code">{{ form.errors.code}}</span>
        </labeL>
        <label class="flex flex-col gap-2">
          <span>description</span>
          <input v-model="form.description" />
          <span v-if="form.errors.description">{{ form.errors.description}}</span>
        </labeL>
        <button>Create</button>
      </form>
    </section>
  </authenticated-layout>
</template>
<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import CourseCreationData = App.Data.CourseCreationData;


const form = useForm<CourseCreationData>({
  name: "",
  code: "",
  description: ""
});
</script>