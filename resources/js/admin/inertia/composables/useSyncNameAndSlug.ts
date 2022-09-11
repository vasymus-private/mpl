import {ref, watch} from "vue"
import {slugify} from "@/admin/inertia/modules/common"
import {FieldContext} from "vee-validate"


export default (name: FieldContext<string|null>['value'], setSlugValue: FieldContext<string|null>['setValue']) => {
    const generateSlugSyncMode = ref<boolean>(false)

    const watchGenerateSlugSyncMode = () => {
        watch(generateSlugSyncMode, newV => {
            if (newV) {
                handleSyncNameAndSlug();
            }
        })
    }

    const handleSyncNameAndSlug = async () => {
        if (!generateSlugSyncMode.value) {
            return
        }

        if (!name.value) {
            return
        }

        const slug = await slugify(name.value)

        setSlugValue(slug)
    }

    return {
        generateSlugSyncMode,
        handleSyncNameAndSlug,
        watchGenerateSlugSyncMode,
    }
}
