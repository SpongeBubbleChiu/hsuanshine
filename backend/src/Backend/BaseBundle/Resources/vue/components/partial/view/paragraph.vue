<template>
    <div class="form-group" :class="setGrid(config.grid)">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">
            {{ config.text|trans }}
        </label>
        <div class="control-data col-md-8 col-sm-8 col-xs-12" v-html="renderData">
        </div>
    </div>
</template>

<script lang="babel!coffee" type="text/coffeescript">
module.exports =
    props: ['config']
    mixins: [require "components/backendbase/mixins/viewComponent.coffee"]
    computed:
        viewData: () ->
            return @$store.getters.view.data
        renderData: () ->
            data = @viewData
            for node in @config.name.split('.')
                if data[node] != undefined && data[node] != null
                    data = data[node]
                else
                    data = ''
            if typeof data == 'string'
                data = data.replace /\n/g, '<br />'
            return @trans data
    methods:
        trans: (label) ->
            if @config.label_prefix != undefined
                label = "#{@config.label_prefix}.#{label}"
            @$options.filters.trans label
</script>

<style lang="sass?indentedSyntax" type="text/sass" scoped>
.form-group
    border-color: 1px #ccc solid

    .control-data
        margin-top: 8px
        padding: 15px
        height: 150px
        overflow-y: auto
        border: 1px solid #ddd
</style>