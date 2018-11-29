<template>
  <div class="hello">
    {{ form }}
  </div>
</template>

<script lang="coffee">
import api from "libs/api.coffee"
export default
  created: () ->
    @init()
  methods:
    init: () ->
      console.log @form, api
  data: () ->
    form:
      title: ""
      content: ""
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
