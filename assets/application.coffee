do ($ = jQuery) ->
    thumbnails = $ '.thumbnails'
    thumbnails.on 'click', 'a.modal-image', ->
        href   = $(this).attr 'href'
        target = $(this).data().target

        $('.modal-body img', target).attr 'src', href
        $(target).modal()
        false
    thumbnails.on 'click', '.close-trigger', ->
        $(this).closest('li').hide('slow')
        false

    items           = thumbnails.find 'li'
    total           = items.length

    return if total is 0

    preloader_count = items.length
    loading         = $('<div class="progress"><div class="bar" style="width:0%;"></div></div>').insertBefore thumbnails
    stack           = new Array()

#
    callback_done = ->
        preloader_count -= 1
        percent          = 100 * (1 - preloader_count / total)
        $('.bar', loading).css width: "#{percent.toFixed(2)}%"
        return unless preloader_count is 0

        delay     = 0
        increment = 100
        stack.sort (a, b) ->
            resolution_a = parseInt b.data().resolution, 10
            resolution_b = parseInt a.data().resolution, 10
            return resolution_a - resolution_b

        loading.remove()
        $.each stack, ->
            thumbnails.append @
            setTimeout(
                => @show 'slide'
                delay
            )
            delay += increment

#
    items.each ->
        img   = new Image()
        src   = $('.original-image', this).attr 'href'
        $that = $(this).hide()

        img.onload = ->
            width  = parseInt @width, 10
            height = parseInt @height, 10

            $('.dimensions', $that).text "#{width} x #{height}"
            $that.data 'resolution', width * height
            stack.push $that

            callback_done()
        img.onerror = callback_done
        img.src = src
