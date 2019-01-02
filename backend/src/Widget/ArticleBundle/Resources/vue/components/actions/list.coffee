abstractList = require "components/backendbase/actions/abstract-list.coffee"

class ArticleList extends abstractList
  _init: () ->
    require('components/widgetarticle/actions/api.coffee') @api
  _getConfig: () ->
#    config
    require('components/widgetarticle/config/list.coffee')
# 資料請求
  request: () -> @api.article.search @_searchData()
# 批次處理
  batch: (ids, action, column) ->
    @api.article.batch ids, action, column

# 快速編輯, 切換狀態
  quickEdit: (id, data) -> @api.article.update id, data

# 刪除資料
  deleteData: (id) -> @api.article.delete id

module.exports = (api) ->
  new ArticleList(api)
