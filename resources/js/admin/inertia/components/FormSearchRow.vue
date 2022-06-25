<template>
    <div class="search form-group row">
        <div class="col-xs-12 col-sm-8">
            <div class="input-group mb-3">
                <b-input-group-prepend v-for="prepend in prepends" :key="prepend.label">
                    <span style="max-width: 200px;" class="input-group-text d-inline-block text-truncate">{{prepend.label}}</span>
                    <b-button @click="change(types.FORM_SEARCH_ROW_PREPEND_CLICK, prepend)" class="btn input-group-prepend__remove"></b-button>
                </b-input-group-prepend>
                <b-form-input
                    v-model="search"
                    @change="change(types.FORM_SEARCH_ROW_ON_SEARCH_CHANGE)"
                    type="text"
                    placeholder="Фильтр + поиск"
                    aria-label="Фильтр + поиск"
                    aria-describedby="search-button"
                ></b-form-input>
                <b-input-group-append>
                    <b-button @click="change(types.FORM_SEARCH_ROW_CLEAR_ALL)" class="btn-outline-secondary"><i class="fa fa-times" aria-hidden="true"></i></b-button>
                    <b-button @click="change(types.FORM_SEARCH_ROW_HANDLE_SEARCH)" class="btn-outline-secondary search-icon" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></b-button>
                </b-input-group-append>
            </div>
        </div>
        <div v-if="options.length" class="col-xs-12 col-sm-2">
            <b-form-select
                v-model="selectedValue"
                @change="change(types.FORM_SEARCH_ROW_SELECT_VALUE)"
                :options="options"
                value-field="value"
                text-field="label"
            >
                <template #first>
                    <b-form-select-option :value="null">Производитель</b-form-select-option>
                </template>
            </b-form-select>
        </div>
        <div v-if="newRoute" class="col-xs-12 col-sm-2">
            <div class="dropdown">
                <Link :href="newRoute" class="btn btn-add btn-secondary">Создать</Link>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import childTypes from "@/admin/inertia/mixins/childTypes";

export default {
    props: {
        newRoute: {
            type: String,
            default: '',
        },
        selected: {
            type: [Object, null],
            default: null
        },
        options: {
            type: Array,
            default: () => []
        },
        prepends: {
            type: Array,
            default: () => [],
        }
    },
    components: {
        Link
    },
    mixins: [
        childTypes,
    ],
    data() {
        return {
            selectedValue: this.selected ? {} : null, //  Vue.util.extend({}, this.selected) : null,
            search: '',
        }
    },
    methods: {
        change(type, ...args) {
            console.log(type, args)
            this.$emit(type, args)
        }
    }
}
</script>
