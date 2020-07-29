<template>
  <div class="topics">
    <table style="margin: auto;">
      <tr v-for="(data, index) in topicsData" :key="index">
        <td>{{ data['name'] }}</td>
        <td><router-link :to="{ name: 'edit', params: { id: index }}">編集</router-link></td>
        <td><button>削除</button></td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      topicsData: []
    }
  },
  mounted() {
    this.axios.get('/api/pages').then((res) => {
      this.topicsData = res.data
    })
  },
}
</script>