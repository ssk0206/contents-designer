<template>
  <div class="edit">
    <button v-on:click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
  </div>
</template>

<script>
export default {
  data() {
    return {

    }
  },
  methods: {
    addComponent: function(id) {
      console.log(id)
    }
  },
}
</script>