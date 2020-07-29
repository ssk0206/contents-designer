<template>
  <div class="edit">
    <button v-on:click="addComponent(1)">+</button>
    <h1>This is an edit page {{ $route.params.id }}</h1>
    <div v-for="(component, index) in components" :key="index">
      <p v-if="component.type == 1">
        {{ component.columns[0].content }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      components: []
    }
  },
  methods: {
    addComponent: function(id) {
      console.log(id)
    }
  },
  mounted() {
    this.axios.get('/api/pages/' + this.$route.params.id + '/edit' ).then((res) => {
      this.components = res.data.components
    })
  },
}
</script>