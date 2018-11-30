import 'libs/request.coffee'
import {apibase} from "@/static/apibase.json"
import real from 'libs/api/real.coffee'
class API
  constructor: () ->
    @ajaxCounter = 0
    @timeout = null
    $.requestConfig
      apiBase: apibase
      overrideMethod: true
  getPendingRequestCountAsync: () ->
    me = @
    if @timeout != null
      window.clearTimeout @timeout
      @timeout = null
    if @ajaxCounter != 0
      return new Promise (resolve) ->
        resolve me.ajaxCounter
    return new Promise (resolve, reject) ->
      me.timeout = window.setTimeout () ->
        resolve me.ajaxCounter
      , 200
  _getToken: () ->
    return null
  _request: (type, url, data = null, withToken = true) ->
    me = @
    @ajaxCounter++
    return new Promise (resolve, reject) ->
      requestConfig =
        type:     type
        url:      url
        processData: true
        jsonDataRequest: true
        xhrFields: {}
        dataType: 'JSON'
        data:      data
        headers: {}
        success:   (result) ->
          me.ajaxCounter--
          resolve result
        error:     (result) ->
          me.ajaxCounter--
          reject result
      requestConfig.headers.Authorization = "Bearer #{me._getToken()}" if me._getToken() != null && withToken
      $.request requestConfig
  multipartRequest: (url, data, onProgress = null, withToken = true) ->
    me = @
    return new Promise (resolve, reject) ->
      requestConfig =
        type: 'POST'
        url:  url
        contentType: false
        processData: false
        xhrFields: {}
        data: data
        dataType: 'json'
        jsonDataRequest: false
        headers: {}
        xhr: () ->
          xhr = $.ajaxSettings.xhr()
          xhr.upload.addEventListener 'progress', (progress) ->
            onProgress(progress) if onProgress
          , false
          return xhr
        success: (result) ->
          resolve result
          return
        error: (result) ->
          reject result
          return
      requestConfig.headers.Authorization = "Bearer #{me._getToken()}" if me._getToken() != null && withToken
      $.request requestConfig
API = real API
export default new API()
