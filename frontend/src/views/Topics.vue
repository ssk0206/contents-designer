<template>
  <div class="topics">
    <table style="margin: auto;">
      <tr v-for="(data, index) in topicsData" :key="index">
        <td>{{ data }}</td>
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
      topicsData: [
        "1",
        "2"
      ]
    }
  },
}
</script>