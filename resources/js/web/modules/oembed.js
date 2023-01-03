;(function ($) {
    function insertAfter(referenceNode, newNode) {
        referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
    }

    $().ready(() => {
        document.querySelectorAll('oembed[url]').forEach(element => {
            const iframe = document.createElement('iframe')
            iframe.setAttribute('height', '480')
            iframe.setAttribute('width', '100%')
            iframe.setAttribute('allowfullscreen', '')
            iframe.setAttribute('src', element.getAttribute('url'))

            insertAfter(element, iframe)
        });
    })
})(jQuery)
