import Media from "@/admin/inertia/modules/common/Media"
import axios from "axios"
import { blobToFile, randomId } from "@/admin/inertia/utils"

export const copyMedia = async (
    original: Media | null
): Promise<Media | null> => {
    if (!original || !original.url) {
        return null
    }

    try {
        let { data: blob }: { data: Blob } = await axios.get(original.url, {
            responseType: "blob",
        })
        let file = blobToFile(blob, original.file_name)

        return {
            id: null,
            uuid: randomId(),
            name: original.name,
            file_name: original.file_name,
            order_column: original.order_column,
            url: URL.createObjectURL(file),
            file,
        }
    } catch (e) {
        console.warn(e)
        return null
    }
}
