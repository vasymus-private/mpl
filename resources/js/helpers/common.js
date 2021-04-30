export const numberWithSpaces = num => {
    let parts = num.toString().split(".")
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    return parts.join(".")
}

export const arrayPrimitivesToObj = (arr, fill = null) => arr.reduce(
    (res, curr) => {
        res = {...res, [curr] : fill}
        return res
    },
    {}
)

export const hideOnClickOutside = (selector, hideCB) => {
    const outsideClickListener = (event) => {
        const $target = $(event.target);
        if (!$target.closest(selector).length && $(selector).is(':visible')) {
            if (typeof hideCB === "function") hideCB()
            else $(selector).hide();

            removeClickListener();
        }
    }

    function removeClickListener() {
        document.removeEventListener('click', outsideClickListener)
    }

    document.addEventListener('click', outsideClickListener)
}

export const guidGenerator = () => {
    let S4 = function() {
        return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
    };
    return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
}
