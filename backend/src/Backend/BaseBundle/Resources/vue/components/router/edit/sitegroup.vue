<template>
    <div class="page-content">
        <!-- useCustomize: 載入客製元件 -->
        <edit :editSetting="editSetting" :useCustomize="customize"></edit>
    </div>
</template>

<script lang="babel!coffee" type="text/coffeescript">
module.exports =
    mixins: [require "components/backendbase/mixins/editConfig.coffee"]
    data: () ->
      customize: []
    events:
      "form.postSaveSuccess": (result, redirect) ->
        if redirect != undefined
          @$router.replace
            name: "sitegroup-list"
        else
          @$router.replace
            name: "sitegroup-edit"
            params:
              id: result.id
        return
    methods:
      getModel: () ->
        require('components/backendbase/actions/edit/sitegroup.coffee')
</script>
