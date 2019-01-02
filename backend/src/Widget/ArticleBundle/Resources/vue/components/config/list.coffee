module.exports =
{
  "list": {
    "id": {
      "label": "#"
      "type": "id"
      "sort": true
      "search": true
      searchConfig:
        key: "name"
        type: "text"
        like: true
    }
    "type": {
      "label": "index.article.type"
      "type": "text"
      "sort": true
      "quick": true
      "search": true
      searchConfig:
        key: "type"
        type: "text"
        like: true
    }
    "title": {
      "label": "index.article.title"
      "type": "text"
      "quick": true
      "search": true
      searchConfig:
        key: "title"
        type: "text"
        like: true
    }
    "created_at": {
      "label": "index.article.created_at"
      "type": "datetime-local"
      "sort": true
      defaultSorting: 'desc'
    }
    "updated_at": {
      "label": "index.article.updated_at"
      "type": "datetime-local"
      "sort": true
    }
  }
  "extra": [
    {
      "name": "new"
      "label": "form.button.new"
      "roles": ["ROLE_ARTICLE_WRITE"]
      "route": 'article-new'
    }
  ]
  "action": [
    {
      "name": "edit"
      "label": "action.edit"
      "roles": ["ROLE_ARTICLE_WRITE"]
      "route": 'article-edit'
    }
    {
      "name": "delete"
      "label": "action.delete"
      "roles": ["ROLE_ARTICLE_WRITE"]
      "component": require 'components/backendbase/partial/list/table/actions/delete.vue'
    }
  ]
}