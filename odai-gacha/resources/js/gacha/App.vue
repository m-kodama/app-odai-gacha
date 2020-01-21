<template>
  <div>hello vue {message}</div>
</template>

<script>
export default {
  name: 'app',
  data: () => ({
    message: 'こんにちはvue'
  }),
}
</script>

<style>
div {
  background-color: #ff0000;
}
</style>