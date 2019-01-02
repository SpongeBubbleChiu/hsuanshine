module.exports = (api) ->
  api.article =
    search: (data) ->
      api.request "GET", "/articles", data
    create: (data) ->
      api.request "POST", "/articles", data
    read: (id) ->
      api.request "GET", "/article/#{id}"
    update: (id, data) ->
      api.request  "PUT", "/article/#{id}", data
    delete: (id) ->
      api.request  "DELETE", "/article/#{id}"
    batch: (ids, action, column) ->
      api.request  "PUT", "/articles",
        ids: ids
        action: action
        column: column
