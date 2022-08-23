export class CustomFormData extends FormData {
    setStringOrNumber(key: string, value: string|number|null|undefined): void {
        if (value == null) {
            return;
        }

        this.set(key, `${value}`)
    }

    setBoolean(key: string, value: boolean|null|undefined): void {
        if (value == null) {
            return;
        }

        this.set(key, `${+value}`)
    }

    setFile(key: string, value: File|null|undefined): void {
        if (value == null) {
            return;
        }

        this.set(key, value)
    }

    appendStringOrNumber(key: string, value: string|number|null|undefined): void {
        if (value == null) {
            return;
        }

        this.append(key, `${value}`)
    }

    appendBoolean(key: string, value: boolean|null|undefined): void {
        if (value == null) {
            return;
        }

        this.append(key, `${+value}`)
    }

    appendFile(key: string, value: File|null|undefined): void {
        if (value == null) {
            return;
        }

        this.append(key, value)
    }

    appendArray(key: string, value: Array<string|number>): void {
        key = key.replace('[]', '')

        value.forEach(v => this.appendStringOrNumber(`${key}[]`, v))
    }
}
