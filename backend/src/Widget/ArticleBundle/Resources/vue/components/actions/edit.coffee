abstractEdit = require "components/backendbase/actions/abstract-edit.coffee"

class ArticleEdit extends abstractEdit
  _init: () ->
    require("components/widgetarticle/actions/api.coffee") @api
  injectConfig: () ->
    require 'components/widgetarticle/config/edit.coffee'
# 取得資料
  _getData: (id) ->
    @api.article.read id
# 儲存表單
  save: () ->
    @api.article.update @editSetting.dataRow.id, @editSetting.dataRow
  create: () ->
    @api.article.create @editSetting.dataRow
module.exports = (api, id) ->
  new ArticleEdit(api, id)