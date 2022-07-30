import { defineRule, configure } from "vee-validate"
import {
    required,
    alpha_dash,
    one_of,
    integer,
    max,
    min,
} from "@vee-validate/rules"
import { localize, setLocale } from "@vee-validate/i18n"
// @ts-ignore
import ru from "@vee-validate/i18n/dist/locale/ru.json"

defineRule("required", required)
defineRule("alpha_dash", alpha_dash)
defineRule("one_of", one_of)
defineRule("integer", integer)
defineRule("max", max)
defineRule("min", min)

configure({
    generateMessage: localize({
        ru,
    }),
})

setLocale("ru")
