import Vue from 'vue'

const funcs = {
  // Build the parameters for the GET based on the filters.repertoire
  buildFilterParams (filter) {
    let filters = JSON.parse(JSON.stringify(filter))
    let params = {}
    let sortParams = funcs.buildSortParams(filters.sort)
    let relatedParams = funcs.buildRelatedParams(filters.related)
    let searchParams = filters.search
    let pageParams = filters.page

    if (pageParams !== '') {
      params['page'] = pageParams
    }

    if (sortParams !== '') {
      params['sort'] = sortParams
    }

    if (Object.keys(filters.dates).length > 0) {
      let datesParams = {}
      for (let param in filters.dates) {
        if (filters.dates[param].after || filters.dates[param].before) {
          datesParams[param] = filters.dates[param].after + ',' + filters.dates[param].before
        }
      }

      if (!params.filters) {
        Vue.set(params, 'filters', {})
      }

      Vue.set(params['filters'], 'dates', datesParams)
    }

    if (Object.keys(relatedParams).length > 0) {
      for (let param in relatedParams) {
        if (relatedParams.hasOwnProperty(param)) {
          if (relatedParams[param] === '') {
            Vue.delete(relatedParams, param)
          }
        }
      }
      if (!params.filters) {
        Vue.set(params, 'filters', {})
      }

      Vue.set(params['filters'], 'related', relatedParams)
    }

    if (Object.keys(searchParams).length > 0) {
      for (let param in searchParams) {
        if (searchParams.hasOwnProperty(param)) {
          if (searchParams[param] === '') {
            Vue.delete(searchParams, param)
          }
        }
      }
      if (!params.filters) {
        Vue.set(params, 'filters', {})
      }

      Vue.set(params['filters'], 'search', searchParams)
    }

    params = funcs.serialize(params)

    return params
  },

  // Build the sort parameters
  buildSortParams (sorts) {
    var sortString = ''

    for (const prop in sorts) {
      sortString += (sorts[prop] === 'desc') ? '-' + prop : prop
      sortString += ','
    }

    sortString = sortString.substr(0, sortString.length - 1)

    return sortString
  },

  // Build the related parameters
  buildRelatedParams (related) {
    var relatedParams = {}

    for (const prop in related) {
      relatedParams[prop] = related[prop].join()
    }

    return relatedParams
  },

  // Build the related parameters
  buildSearchParams (search) {
    var searchParams = {}

    for (const prop in search) {
      searchParams[prop] = search[prop].join()
    }

    return searchParams
  },

  serialize (obj, prefix) {
    var str = []
    var p

    for (p in obj) {
      if (obj.hasOwnProperty(p)) {
        var k = prefix ? prefix + '[' + p + ']' : p
        var v = obj[p]

        str.push((v !== null && typeof v === 'object') ? funcs.serialize(v, k) : encodeURIComponent(k) + '=' + encodeURIComponent(v))
      }
    }

    return str.join('&')
  },

  formatMoney (n) {
    let j = 0
    let c = 2
    let d = '.'
    let t = ','
    let s = n < 0 ? '-' : ''
    let i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c)))

    j = (j = i.length) > 3 ? j % 3 : 0

    return '$' + (s + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : ''))
  }
}

export default funcs
