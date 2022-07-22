import { AxiosInstance } from "axios"
import { Config, InputParams, Router } from "ziggy-js"

declare global {
    interface Window {
        _: Lodash
        axios: AxiosInstance
        /**
         * @see /resources/vendor/ckeditor5
         * */
        ClassicEditor: {}
    }

    declare function route(): Router
    declare function route(
        name: string,
        params?: InputParams,
        absolute?: boolean,
        customZiggy?: Config
    ): string
}
