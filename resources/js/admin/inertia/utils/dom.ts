/*
 * @see https://usefulangle.com/post/179/jquery-offset-vanilla-javascript
 */
export const getOffSet = (el: HTMLElement): { top: number, left: number } => {
    let rect = el.getBoundingClientRect()

    return {
        top: rect.top + window.scrollY,
        left: rect.left + window.scrollX,
    }
}

export const getWindowScrollTop = (): number => window.scrollY || document.documentElement.scrollTop || document.body.scrollTop || 0

/*
 * @see https://gist.github.com/joshcarr/2f861bd37c3d0df40b30
 */
export const getWindowSize = (): {width: number, height: number} => {
    return {
        width: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
        height: window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight,
    }
}

export const getElementSizeWithoutPadding = (el: HTMLElement): {width: number, height: number} => {
    let computedStyle = getComputedStyle(el)

    let elWidth = el.clientWidth
    let elHeight = el.clientHeight

    return {
        width: elWidth - parseFloat(computedStyle.paddingLeft) - parseFloat(computedStyle.paddingRight),
        height: elHeight - parseFloat(computedStyle.paddingTop) - parseFloat(computedStyle.paddingBottom),
    }
}
