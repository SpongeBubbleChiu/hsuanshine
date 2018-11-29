<template>
  <div class="error">
      Oops! This page is not available
  </div>
</template>

<script lang="coffee" type="text/coffeescript">
export default {
  metaInfo:
    title: 'Page Not Found'
    meta: [
      {
        vmid: 'prerender-status-code'
        name: 'prerender-status-code'
        content: '404'
      }
    ]
}
</script>

<style lang="sass" type="text/sass" scoped>
  .error
    width: 100%
    text-align: center
    padding:  10% 0
    font-size: 5rem
</style>
