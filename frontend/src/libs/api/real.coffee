export default (API) ->
  class RealAPI extends API
    test: () ->
      return new Promise (resolve, reject) ->
        resolve "success"
  return RealAPI
