const acceptH = "Accept"
const contentTypeH = "Content-Type"
const xRequestedWithH = "X-Requested-With"
//const authorizationH = "Authorization"
const xcsrfTokenH = "X-CSRF-TOKEN"

class Rest {
    constructor() {
        this._accept = "application/json, text/plain, */*"
        this._contentType = "application/json;charset=UTF-8"
        this._xRequestedWith = "XMLHttpRequest"
        this._token = null

        let token = document.head.querySelector('meta[name="csrf-token"]');

        if (token) {
            this._xcsrfToken = token.content
        } else {
            console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    }

    GET = (url) => {
        let f = fetch(url, {
            method : "GET",
            headers : this.getHeaders(),
        })
        return f
    }

    POST = (url, body = {}, method = "POST") => {
        let f = fetch(url, {
            method : method,
            headers : this.getHeaders(),
            body : JSON.stringify(body)
        })
        return f
    }

    PUT = (url, body = {}) => {
        return this.POST(url, body, "PUT")
    }

    DELETE = (url, body = {}) => {
        return this.POST(url, body, "DELETE")
    }

    // TODO refactor to multiple
    FILE = (url, file) => {
        let data = new FormData()
        data.append('file', file)

        let f = fetch(url, {
            method : "POST",
            headers : {
                'Process-Data' : false,
                'Cache' : false,
                'Accept': '*/*',
                [xRequestedWithH] : this._xRequestedWith,
                //[authorizationH] : this.getAuthorizationH()
            },
            body : data
        })
        return f
    }

    getHeaders = () => ({
        [acceptH] : this._accept,
        [contentTypeH] : this._contentType,
        [xRequestedWithH] : this._xRequestedWith,
        [xcsrfTokenH] : this._xcsrfToken,
        //[authorizationH] : this.getAuthorizationH()
    })

    //getAuthorizationH = () => `Bearer ${this.getToken()}`

    //setToken = (token) => this._token = token
    //getToken = () => this._token

    middleThen = response => {
        if (response.status >= 400) throw new Error(response.statusText)
        return response.json()
    }

    middleNoContent = response => {
        if (response.status >= 400) throw new Error(response.statusText)
    }

    simpleCatch = error => console.warn(error)
}

const rest = new Rest()


// TODO dev only
window.__Rest = rest


export default rest
