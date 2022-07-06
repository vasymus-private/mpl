/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheLayout.vue */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue");
/* harmony import */ var _admin_inertia_modules_articles__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/articles */ "./resources/js/admin/inertia/modules/articles/index.ts");





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'Index',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var articlesStore = (0,_admin_inertia_modules_articles__WEBPACK_IMPORTED_MODULE_3__.useArticlesStore)();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      console.log('--- articles', articlesStore.entities);
    });
    var __returned__ = {
      articlesStore: articlesStore,
      Head: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Head,
      TheLayout: _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");
/* harmony import */ var _admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/modules/columns */ "./resources/js/admin/inertia/modules/columns/index.ts");
/* harmony import */ var _admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/products */ "./resources/js/admin/inertia/modules/products/index.ts");
/* harmony import */ var _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheLayout.vue */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue");
/* harmony import */ var _admin_inertia_shared_layout_Pagination_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/admin/inertia/shared/layout/Pagination.vue */ "./resources/js/admin/inertia/shared/layout/Pagination.vue");







/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'Index',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var selectAll = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    var editMode = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)(false);
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.watch)(selectAll, function (newValue, oldValue) {
      console.log('watch select all', newValue, oldValue);
    });
    var columnsStore = (0,_admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_2__.useColumnsStore)();
    var productStore = (0,_admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_3__.useProductsStore)();
    var checkedProducts = (0,vue__WEBPACK_IMPORTED_MODULE_0__.ref)([]);
    var perPageOptions = (0,_admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_3__.getPerPageOptions)();
    var __returned__ = {
      selectAll: selectAll,
      editMode: editMode,
      columnsStore: columnsStore,
      productStore: productStore,
      checkedProducts: checkedProducts,
      perPageOptions: perPageOptions,
      routeNames: _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_1__.routeNames,
      ColumnName: _admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_2__.ColumnName,
      isSortableColumn: _admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_2__.isSortableColumn,
      getActiveName: _admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_3__.getActiveName,
      TheLayout: _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_4__["default"],
      Pagination: _admin_inertia_shared_layout_Pagination_vue__WEBPACK_IMPORTED_MODULE_5__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true":
/*!********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheLayout.vue */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue");
/* harmony import */ var _admin_inertia_modules_services__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/services */ "./resources/js/admin/inertia/modules/services/index.ts");





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'Index',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var servicesStore = (0,_admin_inertia_modules_services__WEBPACK_IMPORTED_MODULE_3__.useServicesStore)();
    (0,vue__WEBPACK_IMPORTED_MODULE_0__.onMounted)(function () {
      console.log('--- services', servicesStore.entities);
    });
    var __returned__ = {
      servicesStore: servicesStore,
      Head: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Head,
      TheLayout: _admin_inertia_shared_layout_TheLayout_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true":
/*!******************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _vueuse_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @vueuse/core */ "@vueuse/core");
/* harmony import */ var _vueuse_core__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_vueuse_core__WEBPACK_IMPORTED_MODULE_1__);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'FormControlSelect',
  props: {
    modelValue: {
      type: null,
      required: true
    },
    "class": {
      type: String,
      required: false
    },
    label: {
      type: String,
      required: false
    },
    id: {
      type: String,
      required: false
    },
    nullOption: {
      type: Boolean,
      required: false
    },
    placeholder: {
      type: String,
      required: false
    },
    options: {
      type: Array,
      required: true
    },
    errors: {
      type: Array,
      required: false
    }
  },
  emits: ['update:modelValue'],
  setup: function setup(__props, _ref) {
    var expose = _ref.expose,
        emit = _ref.emit;
    expose();
    var props = __props;
    var data = (0,_vueuse_core__WEBPACK_IMPORTED_MODULE_1__.useVModel)(props, 'modelValue', emit);
    var hasErrors = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return props.errors && props.errors.length;
    });
    var __returned__ = {
      props: props,
      emit: emit,
      data: data,
      hasErrors: hasErrors
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__);


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'NavItem',
  props: {
    idOrHref: {
      type: String,
      required: true
    },
    isInertiaLink: {
      type: Boolean,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    iconClass: {
      type: String,
      required: true
    },
    isCollapse: {
      type: Boolean,
      required: true
    },
    isActiveCollapse: {
      type: Boolean,
      required: false
    },
    isArrowSpace: {
      type: Boolean,
      required: false
    },
    navLinkClass: {
      type: String,
      required: false
    }
  },
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var __returned__ = {
      Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Link
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true":
/*!**********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'PageItem',
  props: {
    link: {
      type: null,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    },
    emitOnPage: {
      type: Boolean,
      required: false
    }
  },
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var props = __props;
    var onFirstPage = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return props.currentPage === 1;
    });
    var hasMorePages = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return props.currentPage < props.lastPage;
    });
    var isPageNumber = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return !props.link.isPrev && !props.link.isNext && !props.link.isSeparator;
    });
    var ariaDisabledListItem = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (props.link.isSeparator) {
        return 'true';
      }

      if (props.link.isPrev && onFirstPage.value) {
        return 'true';
      }

      if (props.link.isNext && !hasMorePages.value) {
        return 'true';
      }

      return null;
    });
    var ariaLabelListItem = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (props.link.isPrev && onFirstPage.value) {
        return 'Предыдущая';
      }

      if (props.link.isNext && !hasMorePages.value) {
        return 'Следующая';
      }

      return null;
    });
    var ariaCurrentListItem = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (isPageNumber.value && props.link.page === props.currentPage) {
        return 'page';
      }

      return null;
    });
    var ariaLabelLinkLike = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (props.link.isPrev && !onFirstPage.value) {
        return 'Предыдущая';
      }

      if (props.link.isNext && hasMorePages.value) {
        return 'Следующая';
      }

      return null;
    });
    var ariaHiddenLinkLike = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (props.link.isPrev && onFirstPage.value) {
        return 'true';
      }

      if (props.link.isNext && !hasMorePages.value) {
        return 'true';
      }

      return null;
    });
    var listItemAttrs = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return {
        'aria-disabled': ariaDisabledListItem.value,
        'aria-label': ariaLabelListItem.value,
        'aria-current': ariaCurrentListItem.value
      };
    });
    var isNotLink = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return props.link.isPrev && onFirstPage.value || props.link.isSeparator || props.link.isNext && !hasMorePages.value || isPageNumber.value && props.link.page === props.currentPage;
    });
    var linkLikeAttrs = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return {
        'aria-hidden': ariaHiddenLinkLike.value,
        'aria-label': ariaLabelLinkLike.value
      };
    });
    var classObj = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return {
        'page-item': true,
        'disabled': !props.link.url,
        'active': props.link.page === props.currentPage
      };
    });
    var linkContent = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      if (props.link.isPrev) {
        return '&lsaquo;';
      }

      if (props.link.isNext) {
        return '&rsaquo;';
      }

      if (props.link.isSeparator) {
        return '...';
      }

      return +props.link.page;
    });
    var __returned__ = {
      props: props,
      onFirstPage: onFirstPage,
      hasMorePages: hasMorePages,
      isPageNumber: isPageNumber,
      ariaDisabledListItem: ariaDisabledListItem,
      ariaLabelListItem: ariaLabelListItem,
      ariaCurrentListItem: ariaCurrentListItem,
      ariaLabelLinkLike: ariaLabelLinkLike,
      ariaHiddenLinkLike: ariaHiddenLinkLike,
      listItemAttrs: listItemAttrs,
      isNotLink: isNotLink,
      linkLikeAttrs: linkLikeAttrs,
      classObj: classObj,
      linkContent: linkContent,
      Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_1__.Link
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_shared_forms_FormControlSelect_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/shared/forms/FormControlSelect.vue */ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue");
/* harmony import */ var _vueuse_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @vueuse/core */ "@vueuse/core");
/* harmony import */ var _vueuse_core__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_vueuse_core__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _admin_inertia_shared_layout_PageItem_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/shared/layout/PageItem.vue */ "./resources/js/admin/inertia/shared/layout/PageItem.vue");





/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'Pagination',
  props: {
    total: {
      type: Number,
      required: true
    },
    currentPage: {
      type: Number,
      required: true
    },
    perPageOptions: {
      type: Array,
      required: true
    },
    perPage: {
      type: null,
      required: true
    },
    links: {
      type: Array,
      required: true
    },
    emitOnPage: {
      type: Boolean,
      required: false
    },
    sizes: {
      type: Array,
      required: false
    }
  },
  emits: ['update:perPage'],
  setup: function setup(__props, _ref) {
    var expose = _ref.expose,
        emit = _ref.emit;
    expose();
    var props = __props;
    var perPage = (0,_vueuse_core__WEBPACK_IMPORTED_MODULE_2__.useVModel)(props, 'perPage', emit);
    var lastPage = (0,vue__WEBPACK_IMPORTED_MODULE_0__.computed)(function () {
      return Math.max(Math.ceil(props.total / +props.perPage.value), 1);
    });
    var __returned__ = {
      props: props,
      emit: emit,
      perPage: perPage,
      lastPage: lastPage,
      FormControlSelect: _admin_inertia_shared_forms_FormControlSelect_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
      PageItem: _admin_inertia_shared_layout_PageItem_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "axios");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _admin_inertia_modules_auth__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/modules/auth */ "./resources/js/admin/inertia/modules/auth/index.ts");
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'TheHeader',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var authStore = (0,_admin_inertia_modules_auth__WEBPACK_IMPORTED_MODULE_2__.useAuthStore)();

    var logout = function logout() {
      axios__WEBPACK_IMPORTED_MODULE_1___default().post(route(_admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_3__.routeNames.ROUTE_LOGOUT)).then(function () {
        window.location.href = '/';
      });
    };

    var __returned__ = {
      authStore: authStore,
      logout: logout,
      routeNames: _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_3__.routeNames
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_shared_layout_TheHeader_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheHeader.vue */ "./resources/js/admin/inertia/shared/layout/TheHeader.vue");
/* harmony import */ var _admin_inertia_shared_layout_TheSidebar_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheSidebar.vue */ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue");



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'TheLayout',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var __returned__ = {
      TheHeader: _admin_inertia_shared_layout_TheHeader_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
      TheSidebar: _admin_inertia_shared_layout_TheSidebar_vue__WEBPACK_IMPORTED_MODULE_2__["default"]
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_shared_layout_NavItem_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/shared/layout/NavItem.vue */ "./resources/js/admin/inertia/shared/layout/NavItem.vue");
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");
/* harmony import */ var _admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/categoriesTree */ "./resources/js/admin/inertia/modules/categoriesTree/index.ts");




/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (/*#__PURE__*/(0,vue__WEBPACK_IMPORTED_MODULE_0__.defineComponent)({
  __name: 'TheSidebar',
  setup: function setup(__props, _ref) {
    var expose = _ref.expose;
    expose();
    var routesStore = (0,_admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__.useRoutesStore)();
    var categoriesTreeStore = (0,_admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_3__.useCategoriesTreeStore)();
    var __returned__ = {
      routesStore: routesStore,
      categoriesTreeStore: categoriesTreeStore,
      NavItem: _admin_inertia_shared_layout_NavItem_vue__WEBPACK_IMPORTED_MODULE_1__["default"],
      RouteTypeEnum: _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__.RouteTypeEnum,
      routeNames: _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__.routeNames
    };
    Object.defineProperty(__returned__, '__isScriptSetup', {
      enumerable: false,
      value: true
    });
    return __returned__;
  }
}));

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["TheLayout"], _attrs, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push("<div".concat(_scopeId, ">"));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["Head"], {
          title: "Статьи"
        }, null, _parent, _scopeId));

        _push("<h1".concat(_scopeId, ">\u0421\u0442\u0430\u0442\u044C\u0438</h1><p").concat(_scopeId, "><button class=\"btn btn-primary\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#collapseExample\" aria-expanded=\"false\" aria-controls=\"collapseExample\"").concat(_scopeId, "> Button with data-bs-target </button></p><div class=\"collapse\" id=\"collapseExample\"").concat(_scopeId, "><div class=\"card card-body\"").concat(_scopeId, "> Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger. </div></div></div>"));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Head"], {
          title: "Статьи"
        }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("h1", null, "Статьи"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("p", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("button", {
          "class": "btn btn-primary",
          type: "button",
          "data-bs-toggle": "collapse",
          "data-bs-target": "#collapseExample",
          "aria-expanded": "false",
          "aria-controls": "collapseExample"
        }, " Button with data-bs-target ")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
          "class": "collapse",
          id: "collapseExample"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
          "class": "card card-body"
        }, " Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger. ")])])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["TheLayout"], _attrs, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push("<div".concat(_scopeId, "><div class=\"breadcrumbs\"").concat(_scopeId, "><a").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("href", _ctx.route($setup.routeNames.ROUTE_ADMIN_HOME)), " class=\"breadcrumbs__item\"").concat(_scopeId, "><span class=\"breadcrumbs__text\"").concat(_scopeId, ">\u0420\u0430\u0431\u043E\u0447\u0438\u0439 \u0441\u0442\u043E\u043B</span></a></div><h1 class=\"adm-title\"").concat(_scopeId, ">\u041A\u0430\u0442\u0430\u043B\u043E\u0433 \u0442\u043E\u0432\u0430\u0440\u043E\u0432 <span class=\"adm-fav-link\"").concat(_scopeId, "></span></h1><div").concat(_scopeId, "><button type=\"button\" class=\"btn btn-primary mb-2 mr-2\"").concat(_scopeId, ">\u041D\u0430\u0441\u0442\u0440\u043E\u0438\u0442\u044C</button></div><div class=\"admin-edit-variations table-responsive\"").concat(_scopeId, "><table class=\"table table-bordered table-hover\"").concat(_scopeId, "><thead").concat(_scopeId, "><tr").concat(_scopeId, "><th scope=\"col\"").concat(_scopeId, "><div class=\"form-check form-check-inline\"").concat(_scopeId, "><input").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrIncludeBooleanAttr)($setup.editMode) ? " disabled" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrIncludeBooleanAttr)(Array.isArray($setup.selectAll) ? (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrLooseContain)($setup.selectAll, null) : $setup.selectAll) ? " checked" : "", " class=\"form-check-input position-static\" type=\"checkbox\"").concat(_scopeId, "></div></th><th scope=\"col\"").concat(_scopeId, ">\xA0</th><!--[-->"));

        (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.columnsStore.adminProductColumns, function (sortableColumn) {
          _push("<th scope=\"col\"".concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(sortableColumn.label), "</th>"));
        });

        _push("<!--]--></tr></thead><tbody".concat(_scopeId, "><!--[-->"));

        (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.productStore.productListItems, function (product) {
          _push("<tr".concat(_scopeId, "><td").concat(_scopeId, "><div class=\"form-check\"").concat(_scopeId, "><input").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrIncludeBooleanAttr)($setup.editMode) ? " disabled" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrIncludeBooleanAttr)(Array.isArray($setup.checkedProducts) ? (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrLooseContain)($setup.checkedProducts, product.id) : $setup.checkedProducts) ? " checked" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("value", product.id), " class=\"form-check-input position-static js-product-item-checkbox\" type=\"checkbox\"").concat(_scopeId, "></div></td><td").concat(_scopeId, "></td><!--[-->"));

          (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.columnsStore.adminProductColumns, function (sortableColumn) {
            _push("<!--[-->");

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.ordering)) {
              _push("<td".concat(_scopeId, "><!--<b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.ordering\"></b-form-input>--><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.ordering), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.name)) {
              _push("<td".concat(_scopeId, "><!--<b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.name\"></b-form-input>--><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.name), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.active)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($setup.getActiveName(product.is_active)), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.unit)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.unit), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.price_purchase)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.price_purchase_formatted), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.price_retail)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.price_retail_formatted), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.admin_comment)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.admin_comment), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.availability)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.availability_status_name_short), "</span></td>"));
            } else {
              _push("<!---->");
            }

            if ($setup.isSortableColumn(sortableColumn, $setup.ColumnName.id)) {
              _push("<td".concat(_scopeId, "><span class=\"main-grid-cell-content\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(product.id), "</span></td>"));
            } else {
              _push("<!---->");
            }

            _push("<!--]-->");
          });

          _push("<!--]--></tr>");
        });

        _push("<!--]--></tbody></table></div>");

        if ($setup.productStore.meta) {
          _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["Pagination"], {
            total: $setup.productStore.meta.total,
            "current-page": $setup.productStore.meta.current_page,
            "per-page": $setup.productStore.getPerPageOption,
            "per-page-options": $setup.perPageOptions,
            links: $setup.productStore.meta.links
          }, null, _parent, _scopeId));
        } else {
          _push("<!---->");
        }

        _push("</div>");
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
          "class": "breadcrumbs"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("a", {
          href: _ctx.route($setup.routeNames.ROUTE_ADMIN_HOME),
          "class": "breadcrumbs__item"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
          "class": "breadcrumbs__text"
        }, "Рабочий стол")], 8
        /* PROPS */
        , ["href"])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("h1", {
          "class": "adm-title"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Каталог товаров "), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
          "class": "adm-fav-link"
        })]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("button", {
          type: "button",
          "class": "btn btn-primary mb-2 mr-2"
        }, "Настроить")]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
          "class": "admin-edit-variations table-responsive"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("table", {
          "class": "table table-bordered table-hover"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("thead", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("th", {
          scope: "col"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
          "class": "form-check form-check-inline"
        }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("input", {
          disabled: $setup.editMode,
          "onUpdate:modelValue": function onUpdateModelValue($event) {
            return $setup.selectAll = $event;
          },
          "class": "form-check-input position-static",
          type: "checkbox"
        }, null, 8
        /* PROPS */
        , ["disabled", "onUpdate:modelValue"]), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $setup.selectAll]])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("th", {
          scope: "col"
        }, " "), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.columnsStore.adminProductColumns, function (sortableColumn) {
          return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("th", {
            key: sortableColumn.value,
            scope: "col"
          }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(sortableColumn.label), 1
          /* TEXT */
          );
        }), 128
        /* KEYED_FRAGMENT */
        ))])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("tbody", null, [((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.productStore.productListItems, function (product) {
          return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("tr", {
            key: product.uuid
          }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", {
            "class": "form-check"
          }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("input", {
            disabled: $setup.editMode,
            "onUpdate:modelValue": function onUpdateModelValue($event) {
              return $setup.checkedProducts = $event;
            },
            value: product.id,
            "class": "form-check-input position-static js-product-item-checkbox",
            type: "checkbox"
          }, null, 8
          /* PROPS */
          , ["disabled", "onUpdate:modelValue", "value"]), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelCheckbox, $setup.checkedProducts]])])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("td"), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.columnsStore.adminProductColumns, function (sortableColumn) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, {
              key: sortableColumn.value
            }, [$setup.isSortableColumn(sortableColumn, $setup.ColumnName.ordering) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 0
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.ordering\"></b-form-input>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.ordering), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.name) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 1
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("<b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.name\"></b-form-input>"), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.name), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.active) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 2
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($setup.getActiveName(product.is_active)), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.unit) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 3
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.unit), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.price_purchase) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 4
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.price_purchase_formatted), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.price_retail) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 5
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.price_retail_formatted), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.admin_comment) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 6
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.admin_comment), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.availability) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 7
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.availability_status_name_short), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $setup.isSortableColumn(sortableColumn, $setup.ColumnName.id) ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("td", {
              key: 8
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
              "class": "main-grid-cell-content"
            }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(product.id), 1
            /* TEXT */
            )])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)], 64
            /* STABLE_FRAGMENT */
            );
          }), 128
          /* KEYED_FRAGMENT */
          ))]);
        }), 128
        /* KEYED_FRAGMENT */
        ))])])]), $setup.productStore.meta ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["Pagination"], {
          key: 0,
          total: $setup.productStore.meta.total,
          "current-page": $setup.productStore.meta.current_page,
          "per-page": $setup.productStore.getPerPageOption,
          "per-page-options": $setup.perPageOptions,
          links: $setup.productStore.meta.links
        }, null, 8
        /* PROPS */
        , ["total", "current-page", "per-page", "per-page-options", "links"])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["TheLayout"], _attrs, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push("<div".concat(_scopeId, ">"));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["Head"], {
          title: "Услуги"
        }, null, _parent, _scopeId));

        _push("<h1".concat(_scopeId, ">\u0423\u0441\u043B\u0443\u0433\u0438</h1></div>"));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["Head"], {
          title: "Услуги"
        }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("h1", null, "Услуги")])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<div".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    "class": $setup.props["class"]
  }, _attrs)), ">"));

  if ($setup.props.label) {
    _push("<label".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("for", $setup.props.id), " class=\"form-label\">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($setup.props.label), "</label>"));
  } else {
    _push("<!---->");
  }

  _push("<select class=\"".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderClass)(['form-select', $setup.hasErrors && 'is-invalid']), "\"").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("id", $setup.props.id), ">"));

  if ($setup.props.nullOption) {
    _push("<option selected disabled value=\"\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($setup.props.placeholder || '(не установлено)'), "</option>"));
  } else {
    _push("<!---->");
  }

  _push("<!--[-->");

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.props.options, function (option) {
    _push("<option".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("value", option), ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(option.label), "</option>"));
  });

  _push("<!--]--></select>");

  if ($setup.hasErrors) {
    _push("<!--[-->");

    (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.props.errors, function (error) {
      _push("<div class=\"invalid-feedback\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(error), "</div>"));
    });

    _push("<!--]-->");
  } else {
    _push("<!---->");
  }

  _push("</div>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<li".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    "class": "nav-item"
  }, _attrs)), ">"));

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderVNode)(_push, (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveDynamicComponent)($props.isInertiaLink ? $setup.Link : 'a'), {
    href: $props.idOrHref,
    "class": ['nav-link', $props.navLinkClass || '', $props.isCollapse && !$props.isActiveCollapse ? 'collapsed' : ''],
    "data-bs-toggle": $props.isCollapse ? 'collapse' : null,
    "data-bs-target": $props.isCollapse ? "#".concat($props.idOrHref) : null,
    "aria-expanded": !$props.isCollapse ? null : $props.isCollapse && $props.isActiveCollapse ? 'true' : 'false',
    "aria-controls": !$props.isCollapse ? null : $props.idOrHref
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        if ($props.isCollapse) {
          _push("<span class=\"adm-arrow-icon\"".concat(_scopeId, "></span>"));
        } else {
          _push("<!---->");
        }

        if ($props.isArrowSpace) {
          _push("<span style=\"".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderStyle)({
            "width": "20px"
          }), "\"").concat(_scopeId, "></span>"));
        } else {
          _push("<!---->");
        }

        _push("<span class=\"".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderClass)($props.iconClass), "\"").concat(_scopeId, "></span><span class=\"nav-link-text\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($props.title), "</span>"));
      } else {
        return [$props.isCollapse ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("span", {
          key: 0,
          "class": "adm-arrow-icon"
        })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), $props.isArrowSpace ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)("span", {
          key: 1,
          style: {
            "width": "20px"
          }
        })) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
          "class": $props.iconClass
        }, null, 2
        /* CLASS */
        ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
          "class": "nav-link-text"
        }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($props.title), 1
        /* TEXT */
        )];
      }
    }),
    _: 1
    /* STABLE */

  }), _parent);

  if ($props.isCollapse) {
    _push("<ul".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("id", $props.idOrHref), " class=\"").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderClass)(['nav', 'collapse', $props.isActiveCollapse ? 'show' : '']), "\">"));

    (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderSlot)(_ctx.$slots, "default", {}, null, _push, _parent);

    _push("</ul>");
  } else {
    _push("<!---->");
  }

  _push("</li>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<li".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    "class": $setup.classObj
  }, $setup.listItemAttrs, _attrs)), ">"));

  if ($setup.isNotLink) {
    _push("<span".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)($setup.linkLikeAttrs, {
      "class": "page-link"
    })), ">").concat($setup.linkContent, "</span>"));
  } else if (!$setup.isNotLink && $setup.props.emitOnPage) {
    _push("<button".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)($setup.linkLikeAttrs, {
      "class": "page-link",
      type: "button"
    })), ">").concat($setup.linkContent, "</button>"));
  } else {
    _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["Link"], (0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
      href: $setup.props.link.url
    }, $setup.linkLikeAttrs, {
      "class": "page-link"
    }), null, _parent));
  }

  _push("</li>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<div".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    "class": "block-pagination"
  }, _attrs)), "><div class=\"row\"><div class=\"").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderClass)("col-sm-".concat($setup.props.sizes ? $setup.props.sizes[0] : 10, " row-line")), "\"><span class=\"block-pagination__text\">\u0412\u0441\u0435\u0433\u043E: ").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($setup.props.total), "</span><div><nav><ul class=\"pagination\"><!--[-->"));

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.props.links, function (link) {
    _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["PageItem"], {
      key: link.label,
      link: link,
      "last-page": $setup.lastPage,
      "current-page": $setup.props.currentPage,
      "emit-on-page": $setup.props.emitOnPage,
      onOnPage: function onOnPage($event) {
        return _ctx.$emit('onPage');
      }
    }, null, _parent));
  });

  _push("<!--]--></ul></nav></div></div><div class=\"".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderClass)("col-sm-".concat($setup.props.sizes ? $setup.props.sizes[1] : 2)), "\">"));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["FormControlSelect"], {
    modelValue: $setup.perPage,
    "onUpdate:modelValue": function onUpdateModelValue($event) {
      return $setup.perPage = $event;
    },
    "class": "form-group row",
    label: "На странице:",
    options: $props.perPageOptions
  }, null, _parent));

  _push("</div></div></div>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<header".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    id: "header",
    "class": "header"
  }, _attrs)), "><nav class=\"navbar navbar-expand-lg\"><a class=\"navbar-brand\"").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("href", _ctx.route($setup.routeNames.ROUTE_WEB_HOME)), ">\u0421\u0430\u0439\u0442</a><button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\"><span class=\"navbar-toggler-icon\"></span></button><div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\"><ul class=\"navbar-nav mr-auto header-menu\"><li class=\"nav-item active\"><a class=\"header-link\"").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttr)("href", _ctx.route($setup.routeNames.ROUTE_ADMIN_HOME)), ">\u0410\u0434\u043C\u0438\u043D\u0438\u0441\u0442\u0440\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435 <span class=\"sr-only\">(current)</span></a></li></ul><ul class=\"navbar-nav ml-auto\"><li class=\"nav-item\"><span class=\"adm-header-user-block\">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)($setup.authStore.userName), "</span></li><li class=\"nav-item\"><button type=\"button\" class=\"adm-header-exit\">\u0412\u044B\u0439\u0442\u0438</button></li></ul></div></nav><div class=\"adm-header-bottom\"></div></header>"));
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<div".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    id: "wrapper",
    "class": "wrapper"
  }, _attrs)), ">"));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["TheHeader"], null, null, _parent));

  _push("<main class=\"d-flex\"><div id=\"resize-container\" class=\"\">");

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["TheSidebar"], null, null, _parent));

  _push("<div id=\"resizer\"></div><div class=\"\" id=\"content\">");

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderSlot)(_ctx.$slots, "default", {}, null, _push, _parent);

  _push("</div></div></main></div>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<aside".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    id: "aside",
    "class": "sidebar-left",
    style: {
      "flex-basis": "330px"
    }
  }, _attrs)), "><nav><ul class=\"nav pt-3\">"));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
    "id-or-href": "categories",
    "is-inertia-link": false,
    title: "Каталог товаров",
    "is-collapse": true,
    "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories),
    "icon-class": "adm-icon iblock_menu_icon_types"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "categories-sub",
          title: "Каталог товаров",
          "is-inertia-link": false,
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categoriesSub),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX),
                title: "Товары",
                "is-inertia-link": true,
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));

              _push("<!--[-->");

              (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($setup.categoriesTreeStore.categories, function (category) {
                _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                  "id-or-href": "categories-".concat(category.id),
                  title: category.name,
                  "is-inertia-link": false,
                  "is-collapse": true,
                  "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, category.id),
                  "icon-class": "adm-icon iblock_menu_icon_sections",
                  "nav-link-class": "sub-level-2"
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
                    if (_push) {
                      _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                        "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                          category_id: category.id
                        }),
                        title: "Товары",
                        "is-inertia-link": true,
                        "is-collapse": false,
                        "icon-class": "adm-arrow-icon-dot",
                        "nav-link-class": "sub-level-3"
                      }, null, _parent, _scopeId));

                      _push("<!--[-->");

                      (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)(category.subcategories, function (subcategory1) {
                        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                          "id-or-href": "categories-".concat(subcategory1.id),
                          title: subcategory1.name,
                          "is-inertia-link": false,
                          "is-collapse": true,
                          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory1.id),
                          "icon-class": "adm-icon iblock_menu_icon_sections",
                          "nav-link-class": "sub-level-3"
                        }, {
                          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
                            if (_push) {
                              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                  category_id: subcategory1.id
                                }),
                                title: "Товары",
                                "is-inertia-link": true,
                                "is-collapse": false,
                                "icon-class": "adm-arrow-icon-dot",
                                "nav-link-class": "sub-level-4"
                              }, null, _parent, _scopeId));

                              _push("<!--[-->");

                              (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)(subcategory1.subcategories, function (subcategory2) {
                                _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                                  "id-or-href": "categories-".concat(subcategory2.id),
                                  title: subcategory2.name,
                                  "is-inertia-link": false,
                                  "is-collapse": true,
                                  "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory2.id),
                                  "icon-class": "adm-icon iblock_menu_icon_sections",
                                  "nav-link-class": "sub-level-4"
                                }, {
                                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
                                    if (_push) {
                                      _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                                        "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                          category_id: subcategory2.id
                                        }),
                                        title: "Товары",
                                        "is-inertia-link": true,
                                        "is-collapse": false,
                                        "icon-class": "adm-arrow-icon-dot",
                                        "nav-link-class": "sub-level-5"
                                      }, null, _parent, _scopeId));

                                      _push("<!--[-->");

                                      (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)(subcategory2.subcategories, function (subcategory3) {
                                        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                                          "id-or-href": "categories-".concat(subcategory3.id),
                                          title: subcategory3.name,
                                          "is-inertia-link": false,
                                          "is-collapse": true,
                                          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                          "icon-class": "adm-icon iblock_menu_icon_sections",
                                          "nav-link-class": "sub-level-5"
                                        }, {
                                          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
                                            if (_push) {
                                              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                                                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                                  category_id: subcategory3.id
                                                }),
                                                title: "Товары",
                                                "is-inertia-link": true,
                                                "is-collapse": false,
                                                "icon-class": "adm-arrow-icon-dot",
                                                "nav-link-class": "sub-level-6"
                                              }, null, _parent, _scopeId));
                                            } else {
                                              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                                  category_id: subcategory3.id
                                                }),
                                                title: "Товары",
                                                "is-inertia-link": true,
                                                "is-collapse": false,
                                                "icon-class": "adm-arrow-icon-dot",
                                                "nav-link-class": "sub-level-6"
                                              }, null, 8
                                              /* PROPS */
                                              , ["id-or-href"])];
                                            }
                                          }),
                                          _: 2
                                          /* DYNAMIC */

                                        }, _parent, _scopeId));
                                      });

                                      _push("<!--]-->");
                                    } else {
                                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                        "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                          category_id: subcategory2.id
                                        }),
                                        title: "Товары",
                                        "is-inertia-link": true,
                                        "is-collapse": false,
                                        "icon-class": "adm-arrow-icon-dot",
                                        "nav-link-class": "sub-level-5"
                                      }, null, 8
                                      /* PROPS */
                                      , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory2.subcategories, function (subcategory3) {
                                        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                          "id-or-href": "categories-".concat(subcategory3.id),
                                          title: subcategory3.name,
                                          "is-inertia-link": false,
                                          "is-collapse": true,
                                          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                          "icon-class": "adm-icon iblock_menu_icon_sections",
                                          "nav-link-class": "sub-level-5"
                                        }, {
                                          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                                category_id: subcategory3.id
                                              }),
                                              title: "Товары",
                                              "is-inertia-link": true,
                                              "is-collapse": false,
                                              "icon-class": "adm-arrow-icon-dot",
                                              "nav-link-class": "sub-level-6"
                                            }, null, 8
                                            /* PROPS */
                                            , ["id-or-href"])];
                                          }),
                                          _: 2
                                          /* DYNAMIC */

                                        }, 1032
                                        /* PROPS, DYNAMIC_SLOTS */
                                        , ["id-or-href", "title", "is-active-collapse"]);
                                      }), 256
                                      /* UNKEYED_FRAGMENT */
                                      ))];
                                    }
                                  }),
                                  _: 2
                                  /* DYNAMIC */

                                }, _parent, _scopeId));
                              });

                              _push("<!--]-->");
                            } else {
                              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                  category_id: subcategory1.id
                                }),
                                title: "Товары",
                                "is-inertia-link": true,
                                "is-collapse": false,
                                "icon-class": "adm-arrow-icon-dot",
                                "nav-link-class": "sub-level-4"
                              }, null, 8
                              /* PROPS */
                              , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory1.subcategories, function (subcategory2) {
                                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                  "id-or-href": "categories-".concat(subcategory2.id),
                                  title: subcategory2.name,
                                  "is-inertia-link": false,
                                  "is-collapse": true,
                                  "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory2.id),
                                  "icon-class": "adm-icon iblock_menu_icon_sections",
                                  "nav-link-class": "sub-level-4"
                                }, {
                                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                      "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                        category_id: subcategory2.id
                                      }),
                                      title: "Товары",
                                      "is-inertia-link": true,
                                      "is-collapse": false,
                                      "icon-class": "adm-arrow-icon-dot",
                                      "nav-link-class": "sub-level-5"
                                    }, null, 8
                                    /* PROPS */
                                    , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory2.subcategories, function (subcategory3) {
                                      return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                        "id-or-href": "categories-".concat(subcategory3.id),
                                        title: subcategory3.name,
                                        "is-inertia-link": false,
                                        "is-collapse": true,
                                        "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                        "icon-class": "adm-icon iblock_menu_icon_sections",
                                        "nav-link-class": "sub-level-5"
                                      }, {
                                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                            "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                              category_id: subcategory3.id
                                            }),
                                            title: "Товары",
                                            "is-inertia-link": true,
                                            "is-collapse": false,
                                            "icon-class": "adm-arrow-icon-dot",
                                            "nav-link-class": "sub-level-6"
                                          }, null, 8
                                          /* PROPS */
                                          , ["id-or-href"])];
                                        }),
                                        _: 2
                                        /* DYNAMIC */

                                      }, 1032
                                      /* PROPS, DYNAMIC_SLOTS */
                                      , ["id-or-href", "title", "is-active-collapse"]);
                                    }), 256
                                    /* UNKEYED_FRAGMENT */
                                    ))];
                                  }),
                                  _: 2
                                  /* DYNAMIC */

                                }, 1032
                                /* PROPS, DYNAMIC_SLOTS */
                                , ["id-or-href", "title", "is-active-collapse"]);
                              }), 256
                              /* UNKEYED_FRAGMENT */
                              ))];
                            }
                          }),
                          _: 2
                          /* DYNAMIC */

                        }, _parent, _scopeId));
                      });

                      _push("<!--]-->");
                    } else {
                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                        "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                          category_id: category.id
                        }),
                        title: "Товары",
                        "is-inertia-link": true,
                        "is-collapse": false,
                        "icon-class": "adm-arrow-icon-dot",
                        "nav-link-class": "sub-level-3"
                      }, null, 8
                      /* PROPS */
                      , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(category.subcategories, function (subcategory1) {
                        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                          "id-or-href": "categories-".concat(subcategory1.id),
                          title: subcategory1.name,
                          "is-inertia-link": false,
                          "is-collapse": true,
                          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory1.id),
                          "icon-class": "adm-icon iblock_menu_icon_sections",
                          "nav-link-class": "sub-level-3"
                        }, {
                          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                category_id: subcategory1.id
                              }),
                              title: "Товары",
                              "is-inertia-link": true,
                              "is-collapse": false,
                              "icon-class": "adm-arrow-icon-dot",
                              "nav-link-class": "sub-level-4"
                            }, null, 8
                            /* PROPS */
                            , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory1.subcategories, function (subcategory2) {
                              return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                "id-or-href": "categories-".concat(subcategory2.id),
                                title: subcategory2.name,
                                "is-inertia-link": false,
                                "is-collapse": true,
                                "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory2.id),
                                "icon-class": "adm-icon iblock_menu_icon_sections",
                                "nav-link-class": "sub-level-4"
                              }, {
                                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                    "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                      category_id: subcategory2.id
                                    }),
                                    title: "Товары",
                                    "is-inertia-link": true,
                                    "is-collapse": false,
                                    "icon-class": "adm-arrow-icon-dot",
                                    "nav-link-class": "sub-level-5"
                                  }, null, 8
                                  /* PROPS */
                                  , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory2.subcategories, function (subcategory3) {
                                    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                      "id-or-href": "categories-".concat(subcategory3.id),
                                      title: subcategory3.name,
                                      "is-inertia-link": false,
                                      "is-collapse": true,
                                      "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                      "icon-class": "adm-icon iblock_menu_icon_sections",
                                      "nav-link-class": "sub-level-5"
                                    }, {
                                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                          "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                            category_id: subcategory3.id
                                          }),
                                          title: "Товары",
                                          "is-inertia-link": true,
                                          "is-collapse": false,
                                          "icon-class": "adm-arrow-icon-dot",
                                          "nav-link-class": "sub-level-6"
                                        }, null, 8
                                        /* PROPS */
                                        , ["id-or-href"])];
                                      }),
                                      _: 2
                                      /* DYNAMIC */

                                    }, 1032
                                    /* PROPS, DYNAMIC_SLOTS */
                                    , ["id-or-href", "title", "is-active-collapse"]);
                                  }), 256
                                  /* UNKEYED_FRAGMENT */
                                  ))];
                                }),
                                _: 2
                                /* DYNAMIC */

                              }, 1032
                              /* PROPS, DYNAMIC_SLOTS */
                              , ["id-or-href", "title", "is-active-collapse"]);
                            }), 256
                            /* UNKEYED_FRAGMENT */
                            ))];
                          }),
                          _: 2
                          /* DYNAMIC */

                        }, 1032
                        /* PROPS, DYNAMIC_SLOTS */
                        , ["id-or-href", "title", "is-active-collapse"]);
                      }), 256
                      /* UNKEYED_FRAGMENT */
                      ))];
                    }
                  }),
                  _: 2
                  /* DYNAMIC */

                }, _parent, _scopeId));
              });

              _push("<!--]-->");
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX),
                title: "Товары",
                "is-inertia-link": true,
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, 8
              /* PROPS */
              , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.categoriesTreeStore.categories, function (category) {
                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                  "id-or-href": "categories-".concat(category.id),
                  title: category.name,
                  "is-inertia-link": false,
                  "is-collapse": true,
                  "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, category.id),
                  "icon-class": "adm-icon iblock_menu_icon_sections",
                  "nav-link-class": "sub-level-2"
                }, {
                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                      "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                        category_id: category.id
                      }),
                      title: "Товары",
                      "is-inertia-link": true,
                      "is-collapse": false,
                      "icon-class": "adm-arrow-icon-dot",
                      "nav-link-class": "sub-level-3"
                    }, null, 8
                    /* PROPS */
                    , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(category.subcategories, function (subcategory1) {
                      return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                        "id-or-href": "categories-".concat(subcategory1.id),
                        title: subcategory1.name,
                        "is-inertia-link": false,
                        "is-collapse": true,
                        "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory1.id),
                        "icon-class": "adm-icon iblock_menu_icon_sections",
                        "nav-link-class": "sub-level-3"
                      }, {
                        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                            "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                              category_id: subcategory1.id
                            }),
                            title: "Товары",
                            "is-inertia-link": true,
                            "is-collapse": false,
                            "icon-class": "adm-arrow-icon-dot",
                            "nav-link-class": "sub-level-4"
                          }, null, 8
                          /* PROPS */
                          , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory1.subcategories, function (subcategory2) {
                            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                              "id-or-href": "categories-".concat(subcategory2.id),
                              title: subcategory2.name,
                              "is-inertia-link": false,
                              "is-collapse": true,
                              "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory2.id),
                              "icon-class": "adm-icon iblock_menu_icon_sections",
                              "nav-link-class": "sub-level-4"
                            }, {
                              "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                  "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                    category_id: subcategory2.id
                                  }),
                                  title: "Товары",
                                  "is-inertia-link": true,
                                  "is-collapse": false,
                                  "icon-class": "adm-arrow-icon-dot",
                                  "nav-link-class": "sub-level-5"
                                }, null, 8
                                /* PROPS */
                                , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory2.subcategories, function (subcategory3) {
                                  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                    "id-or-href": "categories-".concat(subcategory3.id),
                                    title: subcategory3.name,
                                    "is-inertia-link": false,
                                    "is-collapse": true,
                                    "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                    "icon-class": "adm-icon iblock_menu_icon_sections",
                                    "nav-link-class": "sub-level-5"
                                  }, {
                                    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                        "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                          category_id: subcategory3.id
                                        }),
                                        title: "Товары",
                                        "is-inertia-link": true,
                                        "is-collapse": false,
                                        "icon-class": "adm-arrow-icon-dot",
                                        "nav-link-class": "sub-level-6"
                                      }, null, 8
                                      /* PROPS */
                                      , ["id-or-href"])];
                                    }),
                                    _: 2
                                    /* DYNAMIC */

                                  }, 1032
                                  /* PROPS, DYNAMIC_SLOTS */
                                  , ["id-or-href", "title", "is-active-collapse"]);
                                }), 256
                                /* UNKEYED_FRAGMENT */
                                ))];
                              }),
                              _: 2
                              /* DYNAMIC */

                            }, 1032
                            /* PROPS, DYNAMIC_SLOTS */
                            , ["id-or-href", "title", "is-active-collapse"]);
                          }), 256
                          /* UNKEYED_FRAGMENT */
                          ))];
                        }),
                        _: 2
                        /* DYNAMIC */

                      }, 1032
                      /* PROPS, DYNAMIC_SLOTS */
                      , ["id-or-href", "title", "is-active-collapse"]);
                    }), 256
                    /* UNKEYED_FRAGMENT */
                    ))];
                  }),
                  _: 2
                  /* DYNAMIC */

                }, 1032
                /* PROPS, DYNAMIC_SLOTS */
                , ["id-or-href", "title", "is-active-collapse"]);
              }), 256
              /* UNKEYED_FRAGMENT */
              ))];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "categories-sub",
          title: "Каталог товаров",
          "is-inertia-link": false,
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categoriesSub),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX),
              title: "Товары",
              "is-inertia-link": true,
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            }, null, 8
            /* PROPS */
            , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($setup.categoriesTreeStore.categories, function (category) {
              return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                "id-or-href": "categories-".concat(category.id),
                title: category.name,
                "is-inertia-link": false,
                "is-collapse": true,
                "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, category.id),
                "icon-class": "adm-icon iblock_menu_icon_sections",
                "nav-link-class": "sub-level-2"
              }, {
                "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                  return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                    "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                      category_id: category.id
                    }),
                    title: "Товары",
                    "is-inertia-link": true,
                    "is-collapse": false,
                    "icon-class": "adm-arrow-icon-dot",
                    "nav-link-class": "sub-level-3"
                  }, null, 8
                  /* PROPS */
                  , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(category.subcategories, function (subcategory1) {
                    return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                      "id-or-href": "categories-".concat(subcategory1.id),
                      title: subcategory1.name,
                      "is-inertia-link": false,
                      "is-collapse": true,
                      "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory1.id),
                      "icon-class": "adm-icon iblock_menu_icon_sections",
                      "nav-link-class": "sub-level-3"
                    }, {
                      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                          "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                            category_id: subcategory1.id
                          }),
                          title: "Товары",
                          "is-inertia-link": true,
                          "is-collapse": false,
                          "icon-class": "adm-arrow-icon-dot",
                          "nav-link-class": "sub-level-4"
                        }, null, 8
                        /* PROPS */
                        , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory1.subcategories, function (subcategory2) {
                          return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                            "id-or-href": "categories-".concat(subcategory2.id),
                            title: subcategory2.name,
                            "is-inertia-link": false,
                            "is-collapse": true,
                            "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory2.id),
                            "icon-class": "adm-icon iblock_menu_icon_sections",
                            "nav-link-class": "sub-level-4"
                          }, {
                            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                  category_id: subcategory2.id
                                }),
                                title: "Товары",
                                "is-inertia-link": true,
                                "is-collapse": false,
                                "icon-class": "adm-arrow-icon-dot",
                                "nav-link-class": "sub-level-5"
                              }, null, 8
                              /* PROPS */
                              , ["id-or-href"]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)(subcategory2.subcategories, function (subcategory3) {
                                return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createBlock)($setup["NavItem"], {
                                  "id-or-href": "categories-".concat(subcategory3.id),
                                  title: subcategory3.name,
                                  "is-inertia-link": false,
                                  "is-collapse": true,
                                  "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.categories, subcategory3.id),
                                  "icon-class": "adm-icon iblock_menu_icon_sections",
                                  "nav-link-class": "sub-level-5"
                                }, {
                                  "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
                                    return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                                      "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_PRODUCTS_TEMP_INDEX, {
                                        category_id: subcategory3.id
                                      }),
                                      title: "Товары",
                                      "is-inertia-link": true,
                                      "is-collapse": false,
                                      "icon-class": "adm-arrow-icon-dot",
                                      "nav-link-class": "sub-level-6"
                                    }, null, 8
                                    /* PROPS */
                                    , ["id-or-href"])];
                                  }),
                                  _: 2
                                  /* DYNAMIC */

                                }, 1032
                                /* PROPS, DYNAMIC_SLOTS */
                                , ["id-or-href", "title", "is-active-collapse"]);
                              }), 256
                              /* UNKEYED_FRAGMENT */
                              ))];
                            }),
                            _: 2
                            /* DYNAMIC */

                          }, 1032
                          /* PROPS, DYNAMIC_SLOTS */
                          , ["id-or-href", "title", "is-active-collapse"]);
                        }), 256
                        /* UNKEYED_FRAGMENT */
                        ))];
                      }),
                      _: 2
                      /* DYNAMIC */

                    }, 1032
                    /* PROPS, DYNAMIC_SLOTS */
                    , ["id-or-href", "title", "is-active-collapse"]);
                  }), 256
                  /* UNKEYED_FRAGMENT */
                  ))];
                }),
                _: 2
                /* DYNAMIC */

              }, 1032
              /* PROPS, DYNAMIC_SLOTS */
              , ["id-or-href", "title", "is-active-collapse"]);
            }), 256
            /* UNKEYED_FRAGMENT */
            ))];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
    "id-or-href": "reference",
    "is-inertia-link": false,
    title: "Справочники",
    "is-collapse": true,
    "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.reference),
    "icon-class": "adm-icon iblock_menu_icon_types"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "reference-brands",
          "is-inertia-link": false,
          title: "Производители",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceBrands),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_BRANDS_INDEX),
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_BRANDS_INDEX),
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, 8
              /* PROPS */
              , ["id-or-href"])];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "reference-articles",
          "is-inertia-link": false,
          title: "Статьи",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceArticles),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_ARTICLES_INDEX),
                "is-inertia-link": true,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_ARTICLES_INDEX),
                "is-inertia-link": true,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, 8
              /* PROPS */
              , ["id-or-href"])];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "reference-services",
          "is-inertia-link": false,
          title: "Услуги",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceServices),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_SERVICES_INDEX),
                "is-inertia-link": true,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_SERVICES_INDEX),
                "is-inertia-link": true,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, 8
              /* PROPS */
              , ["id-or-href"])];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "reference-faq",
          "is-inertia-link": false,
          title: "Вопрос-ответ",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceFaq),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": "#",
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": "#",
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              })];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          "id-or-href": "reference-contacts",
          "is-inertia-link": false,
          title: "Контактные формы",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceContacts),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
                "id-or-href": "#",
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              }, null, _parent, _scopeId));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
                "id-or-href": "#",
                "is-inertia-link": false,
                title: "Элементы",
                "is-collapse": false,
                "icon-class": "adm-arrow-icon-dot",
                "nav-link-class": "sub-level-2"
              })];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "reference-brands",
          "is-inertia-link": false,
          title: "Производители",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceBrands),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_BRANDS_INDEX),
              "is-inertia-link": false,
              title: "Элементы",
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            }, null, 8
            /* PROPS */
            , ["id-or-href"])];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "reference-articles",
          "is-inertia-link": false,
          title: "Статьи",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceArticles),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_ARTICLES_INDEX),
              "is-inertia-link": true,
              title: "Элементы",
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            }, null, 8
            /* PROPS */
            , ["id-or-href"])];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "reference-services",
          "is-inertia-link": false,
          title: "Услуги",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceServices),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_SERVICES_INDEX),
              "is-inertia-link": true,
              title: "Элементы",
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            }, null, 8
            /* PROPS */
            , ["id-or-href"])];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "reference-faq",
          "is-inertia-link": false,
          title: "Вопрос-ответ",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceFaq),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": "#",
              "is-inertia-link": false,
              title: "Элементы",
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            })];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          "id-or-href": "reference-contacts",
          "is-inertia-link": false,
          title: "Контактные формы",
          "is-collapse": true,
          "is-active-collapse": $setup.routesStore.isActiveRoute($setup.RouteTypeEnum.referenceContacts),
          "icon-class": "adm-icon iblock_menu_icon_iblocks",
          "nav-link-class": "sub-level-1"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
              "id-or-href": "#",
              "is-inertia-link": false,
              title: "Элементы",
              "is-collapse": false,
              "icon-class": "adm-arrow-icon-dot",
              "nav-link-class": "sub-level-2"
            })];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["is-active-collapse"])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
    "id-or-href": "highload",
    "is-inertia-link": false,
    title: "Highload-блоки",
    "is-collapse": true,
    "is-active-collapse": false,
    "icon-class": "adm-icon iblock_menu_icon_types"
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
          title: "Blacklist",
          "id-or-href": "#",
          "is-inertia-link": false,
          "is-collapse": false,
          "icon-class": "adm-arrow-icon-dot",
          "nav-link-class": "sub-level-1"
        }, null, _parent, _scopeId));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)($setup["NavItem"], {
          title: "Blacklist",
          "id-or-href": "#",
          "is-inertia-link": false,
          "is-collapse": false,
          "icon-class": "adm-arrow-icon-dot",
          "nav-link-class": "sub-level-1"
        })];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
    "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_ORDERS_INDEX),
    "is-inertia-link": false,
    title: "Заказы",
    "is-collapse": false,
    "icon-class": "adm-icon iblock_menu_icon_types",
    "is-arrow-space": true
  }, null, _parent));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)($setup["NavItem"], {
    "id-or-href": _ctx.route($setup.routeNames.ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX),
    "is-inertia-link": false,
    title: "Экспорт",
    "is-collapse": false,
    "icon-class": "adm-icon iblock_menu_icon_types",
    "is-arrow-space": true
  }, null, _parent));

  _push("</ul></nav></aside>");
}

/***/ }),

/***/ "./resources/js/admin/inertia/modules/articles/index.ts":
/*!**************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/articles/index.ts ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useArticlesStore": () => (/* binding */ useArticlesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "articles";
var useArticlesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      entities: []
    };
  },
  actions: {
    setEntities: function setEntities(entities) {
      this.entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/auth/index.ts":
/*!**********************************************************!*\
  !*** ./resources/js/admin/inertia/modules/auth/index.ts ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useAuthStore": () => (/* binding */ useAuthStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "auth"; // useStore could be anything like useUser, useCart
// the first argument is a unique id of the store across your application

var useAuthStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      user: {
        id: null,
        name: null,
        email: null,
        phone: null,
        is_anonymous: null
      }
    };
  },
  getters: {
    userName: function userName(state) {
      return state.user.name;
    }
  },
  actions: {
    setAuthUser: function setAuthUser(user) {
      this.user = user;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/availabilityStatuses/index.ts":
/*!**************************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/availabilityStatuses/index.ts ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useAvailabilityStatusesStore": () => (/* binding */ useAvailabilityStatusesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "availabilityStatuses";
var useAvailabilityStatusesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/billStatuses/index.ts":
/*!******************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/billStatuses/index.ts ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useBillStatusesStore": () => (/* binding */ useBillStatusesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "billStatuses";
var useBillStatusesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/brands/index.ts":
/*!************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/brands/index.ts ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useBrandsStore": () => (/* binding */ useBrandsStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "brands";
var useBrandsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _options: []
    };
  },
  getters: {
    options: function options(state) {
      return state._options;
    }
  },
  actions: {
    setOptions: function setOptions(options) {
      this._options = options;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/categoriesTree/index.ts":
/*!********************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/categoriesTree/index.ts ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useCategoriesTreeStore": () => (/* binding */ useCategoriesTreeStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }


var storeName = "categoriesTree";
var useCategoriesTreeStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      entities: []
    };
  },
  getters: {
    getCategoryAndSubtreeIds: function getCategoryAndSubtreeIds(state) {
      return function (id) {
        var categoryAndSubcategories = getCategoryAndSubcategoryCb(state.entities, id);

        if (!categoryAndSubcategories) {
          return null;
        }

        return getIdsCb([], categoryAndSubcategories);
      };
    },
    categories: function categories(state) {
      return state.entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this.entities = entities;
    }
  }
});

var getCategoryAndSubcategoryCb = function getCategoryAndSubcategoryCb(categories, _id) {
  for (var i = 0; i < categories.length; i++) {
    if (categories[i].id === _id) {
      return categories[i];
    }

    var res = getCategoryAndSubcategoryCb(categories[i].subcategories, _id);

    if (res) {
      return res;
    }
  }

  return null;
};

var getIdsCb = function getIdsCb(acc, category) {
  acc = [].concat(_toConsumableArray(acc), [category.id]);

  for (var i = 0; i < category.subcategories.length; i++) {
    acc = getIdsCb(acc, category.subcategories[i]);
  }

  return acc;
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/chars/index.ts":
/*!***********************************************************!*\
  !*** ./resources/js/admin/inertia/modules/chars/index.ts ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useCharsStore": () => (/* binding */ useCharsStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "chars";
var useCharsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _types: []
    };
  },
  getters: {
    types: function types(state) {
      return state._types;
    }
  },
  actions: {
    setChartTypes: function setChartTypes(types) {
      this._types = types;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/columns/index.ts":
/*!*************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/columns/index.ts ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useColumnsStore": () => (/* binding */ useColumnsStore),
/* harmony export */   "ColumnName": () => (/* binding */ ColumnName),
/* harmony export */   "getColumn": () => (/* binding */ getColumn),
/* harmony export */   "isSortableColumn": () => (/* binding */ isSortableColumn)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


var storeName = "columns";
var useColumnsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _adminOrderColumns: [],
      _adminProductColumns: [],
      _adminProductVariantColumns: []
    };
  },
  getters: {
    adminOrderColumns: function adminOrderColumns(state) {
      return state._adminOrderColumns;
    },
    adminProductColumns: function adminProductColumns(state) {
      return state._adminProductColumns;
    },
    adminProductVariantColumns: function adminProductVariantColumns(state) {
      return state._adminProductVariantColumns;
    }
  },
  actions: {
    setAdminOrderColumns: function setAdminOrderColumns(columns) {
      this._adminOrderColumns = columns;
    },
    setAdminProductColumns: function setAdminProductColumns(columns) {
      this._adminProductColumns = columns;
    },
    setAdminProductVariantColumns: function setAdminProductVariantColumns(columns) {
      this._adminProductVariantColumns = columns;
    }
  }
});
var ColumnName;

(function (ColumnName) {
  ColumnName["id"] = "id";
  ColumnName["name"] = "name";
  ColumnName["date_creation"] = "date_creation";
  ColumnName["status"] = "status";
  ColumnName["positions"] = "positions";
  ColumnName["comment_admin"] = "comment_admin";
  ColumnName["importance"] = "importance";
  ColumnName["manager"] = "manager";
  ColumnName["sum"] = "sum";
  ColumnName["phone"] = "phone";
  ColumnName["email"] = "email";
  ColumnName["comment_user"] = "comment_user";
  ColumnName["payment_method"] = "payment_method";
  ColumnName["unit"] = "unit";
  ColumnName["price_purchase"] = "price_purchase";
  ColumnName["price_retail"] = "price_retail";
  ColumnName["admin_comment"] = "admin_comment";
  ColumnName["availability"] = "availability";
  ColumnName["active"] = "active";
  ColumnName["detailed_image"] = "detailed_image";
  ColumnName["additional_images"] = "additional_images";
  ColumnName["ordering"] = "ordering";
  ColumnName["coefficient"] = "coefficient";
  ColumnName["coefficient_description"] = "coefficient_description";
})(ColumnName || (ColumnName = {}));
/**
 * @see src/Domain/Common/Enums/Column.php
 */


var getColumn = function getColumn(key) {
  var _obj;

  var obj = (_obj = {}, _defineProperty(_obj, ColumnName.id, {
    value: 1,
    label: "ID"
  }), _defineProperty(_obj, ColumnName.name, {
    value: 2,
    label: "Имя"
  }), _defineProperty(_obj, ColumnName.date_creation, {
    value: 3,
    label: "Дата создания"
  }), _defineProperty(_obj, ColumnName.status, {
    value: 4,
    label: "Статус"
  }), _defineProperty(_obj, ColumnName.positions, {
    value: 5,
    label: "Позиции"
  }), _defineProperty(_obj, ColumnName.comment_admin, {
    value: 6,
    label: "Комментарии"
  }), _defineProperty(_obj, ColumnName.importance, {
    value: 7,
    label: "Важность"
  }), _defineProperty(_obj, ColumnName.manager, {
    value: 8,
    label: "Менеджер"
  }), _defineProperty(_obj, ColumnName.sum, {
    value: 9,
    label: "Сумма"
  }), _defineProperty(_obj, ColumnName.phone, {
    value: 10,
    label: "Телефон"
  }), _defineProperty(_obj, ColumnName.email, {
    value: 11,
    label: "Email"
  }), _defineProperty(_obj, ColumnName.comment_user, {
    value: 12,
    label: "Комментарий покупателя"
  }), _defineProperty(_obj, ColumnName.payment_method, {
    value: 13,
    label: "Платежная система"
  }), _defineProperty(_obj, ColumnName.unit, {
    value: 14,
    label: "Упаковка"
  }), _defineProperty(_obj, ColumnName.price_purchase, {
    value: 15,
    label: "Закупочная"
  }), _defineProperty(_obj, ColumnName.price_retail, {
    value: 16,
    label: "Розничная"
  }), _defineProperty(_obj, ColumnName.admin_comment, {
    value: 17,
    label: "Служебная Информация"
  }), _defineProperty(_obj, ColumnName.availability, {
    value: 18,
    label: "Наличие"
  }), _defineProperty(_obj, ColumnName.active, {
    value: 19,
    label: "Акт-ть"
  }), _defineProperty(_obj, ColumnName.detailed_image, {
    value: 20,
    label: "Детальная картинка"
  }), _defineProperty(_obj, ColumnName.additional_images, {
    value: 21,
    label: "Дополнительные фото"
  }), _defineProperty(_obj, ColumnName.ordering, {
    value: 22,
    label: "Сорт-ка"
  }), _defineProperty(_obj, ColumnName.coefficient, {
    value: 23,
    label: "Коэффициент"
  }), _defineProperty(_obj, ColumnName.coefficient_description, {
    value: 24,
    label: "Описание коэффициента"
  }), _obj);
  return obj[key];
};
var isSortableColumn = function isSortableColumn(column, name) {
  return column.value === getColumn(name).value;
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/common/index.ts":
/*!************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/common/index.ts ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "extendMetaLinksWithComputedData": () => (/* binding */ extendMetaLinksWithComputedData),
/* harmony export */   "extendUrlWithCurrentParams": () => (/* binding */ extendUrlWithCurrentParams),
/* harmony export */   "extendUrlWithParams": () => (/* binding */ extendUrlWithParams)
/* harmony export */ });
/* harmony import */ var _admin_inertia_utils__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/admin/inertia/utils */ "./resources/js/admin/inertia/utils/index.ts");

var extendMetaLinksWithComputedData = function extendMetaLinksWithComputedData(meta, fullUrl) {
  meta.links.forEach(function (metaLink, index) {
    var labelIsNumeric = (0,_admin_inertia_utils__WEBPACK_IMPORTED_MODULE_0__.isNumeric)(metaLink.label);
    metaLink.isSeparator = metaLink.label === '...';
    metaLink.isPrev = !labelIsNumeric && index === 0 && metaLink.label !== '...';
    metaLink.isNext = !labelIsNumeric && index !== 0 && metaLink.label !== '...';

    if (labelIsNumeric) {
      metaLink.page = +metaLink.label;
    }

    metaLink.url = extendUrlWithCurrentParams(metaLink.url, fullUrl);
  });
  return meta;
};
var extendUrlWithCurrentParams = function extendUrlWithCurrentParams(url, fullUrl) {
  if (!url) {
    return null;
  }

  try {
    var _url = new URL(url);

    var _fullUrl = fullUrl ? fullUrl : typeof location !== 'undefined' ? location.href : null;

    var currentUrl = new URL(_fullUrl);
    currentUrl.searchParams.set('page', _url.searchParams.get('page'));
    return currentUrl.toString();
  } catch (e) {
    return null;
  }
};
var extendUrlWithParams = function extendUrlWithParams(url, _ref) {
  var page = _ref.page;

  var _url = new URL(url);

  _url.searchParams.set('page', "".concat(page));

  return _url.toString();
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/currencies/index.ts":
/*!****************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/currencies/index.ts ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useCurrenciesStore": () => (/* binding */ useCurrenciesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "currencies";
var useCurrenciesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/index.ts":
/*!*****************************************************!*\
  !*** ./resources/js/admin/inertia/modules/index.ts ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "initFromPageProps": () => (/* binding */ initFromPageProps)
/* harmony export */ });
/* harmony import */ var _admin_inertia_modules_auth__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/admin/inertia/modules/auth */ "./resources/js/admin/inertia/modules/auth/index.ts");
/* harmony import */ var _admin_inertia_modules_articles__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/modules/articles */ "./resources/js/admin/inertia/modules/articles/index.ts");
/* harmony import */ var _admin_inertia_modules_services__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/modules/services */ "./resources/js/admin/inertia/modules/services/index.ts");
/* harmony import */ var _admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/admin/inertia/modules/categoriesTree */ "./resources/js/admin/inertia/modules/categoriesTree/index.ts");
/* harmony import */ var _admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/admin/inertia/modules/columns */ "./resources/js/admin/inertia/modules/columns/index.ts");
/* harmony import */ var _admin_inertia_modules_brands__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/admin/inertia/modules/brands */ "./resources/js/admin/inertia/modules/brands/index.ts");
/* harmony import */ var _admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/admin/inertia/modules/products */ "./resources/js/admin/inertia/modules/products/index.ts");
/* harmony import */ var _admin_inertia_modules_availabilityStatuses__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/admin/inertia/modules/availabilityStatuses */ "./resources/js/admin/inertia/modules/availabilityStatuses/index.ts");
/* harmony import */ var _admin_inertia_modules_billStatuses__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @/admin/inertia/modules/billStatuses */ "./resources/js/admin/inertia/modules/billStatuses/index.ts");
/* harmony import */ var _admin_inertia_modules_currencies__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @/admin/inertia/modules/currencies */ "./resources/js/admin/inertia/modules/currencies/index.ts");
/* harmony import */ var _admin_inertia_modules_paymentMethods__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @/admin/inertia/modules/paymentMethods */ "./resources/js/admin/inertia/modules/paymentMethods/index.ts");
/* harmony import */ var _admin_inertia_modules_orderImportance__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @/admin/inertia/modules/orderImportance */ "./resources/js/admin/inertia/modules/orderImportance/index.ts");
/* harmony import */ var _admin_inertia_modules_orderStatuses__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @/admin/inertia/modules/orderStatuses */ "./resources/js/admin/inertia/modules/orderStatuses/index.ts");
/* harmony import */ var _admin_inertia_modules_chars__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @/admin/inertia/modules/chars */ "./resources/js/admin/inertia/modules/chars/index.ts");
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");















/**
 * props on all page + props specific for concrete controller
 * @see \App\Http\Middleware\HandleInertiaRequests::share()
 */

var initFromPageProps = function initFromPageProps(pinia, initialPageProps) {
  var fullUrl = initialPageProps.fullUrl,
      auth = initialPageProps.auth,
      _initialPageProps$cat = initialPageProps.categoriesTree,
      categoriesTree = _initialPageProps$cat === void 0 ? [] : _initialPageProps$cat,
      _initialPageProps$bra = initialPageProps.brandOptions,
      brandOptions = _initialPageProps$bra === void 0 ? [] : _initialPageProps$bra,
      _initialPageProps$adm = initialPageProps.adminOrderColumns,
      adminOrderColumns = _initialPageProps$adm === void 0 ? [] : _initialPageProps$adm,
      _initialPageProps$adm2 = initialPageProps.adminProductColumns,
      adminProductColumns = _initialPageProps$adm2 === void 0 ? [] : _initialPageProps$adm2,
      _initialPageProps$adm3 = initialPageProps.adminProductVariantColumns,
      adminProductVariantColumns = _initialPageProps$adm3 === void 0 ? [] : _initialPageProps$adm3,
      _initialPageProps$ava = initialPageProps.availabilityStatuses.data,
      availabilityStatusesData = _initialPageProps$ava === void 0 ? [] : _initialPageProps$ava,
      _initialPageProps$bil = initialPageProps.billStatuses.data,
      billStatusesData = _initialPageProps$bil === void 0 ? [] : _initialPageProps$bil,
      _initialPageProps$cur = initialPageProps.currencies.data,
      currenciesData = _initialPageProps$cur === void 0 ? [] : _initialPageProps$cur,
      _initialPageProps$pay = initialPageProps.paymentMethods.data,
      paymentMethodsData = _initialPageProps$pay === void 0 ? [] : _initialPageProps$pay,
      _initialPageProps$ord = initialPageProps.orderImportance.data,
      orderImportanceData = _initialPageProps$ord === void 0 ? [] : _initialPageProps$ord,
      _initialPageProps$ord2 = initialPageProps.orderStatuses.data,
      orderStatusesData = _initialPageProps$ord2 === void 0 ? [] : _initialPageProps$ord2,
      _initialPageProps$cha = initialPageProps.charTypes.data,
      charTypesData = _initialPageProps$cha === void 0 ? [] : _initialPageProps$cha,
      _initialPageProps$art = initialPageProps.articles,
      articles = _initialPageProps$art === void 0 ? [] : _initialPageProps$art,
      _initialPageProps$ser = initialPageProps.services,
      services = _initialPageProps$ser === void 0 ? [] : _initialPageProps$ser,
      _initialPageProps$pro = initialPageProps.productListItems;
  _initialPageProps$pro = _initialPageProps$pro === void 0 ? {} : _initialPageProps$pro;
  var _initialPageProps$pro2 = _initialPageProps$pro.data,
      productListItemsData = _initialPageProps$pro2 === void 0 ? [] : _initialPageProps$pro2,
      _initialPageProps$pro3 = _initialPageProps$pro.links,
      productListItemsLinks = _initialPageProps$pro3 === void 0 ? null : _initialPageProps$pro3,
      _initialPageProps$pro4 = _initialPageProps$pro.meta,
      productListItemsMeta = _initialPageProps$pro4 === void 0 ? null : _initialPageProps$pro4; // todo dev only

  if (typeof window !== 'undefined') {
    // @ts-ignore
    window.__initialPageProps = initialPageProps;
  }

  var routesStore = (0,_admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_14__.useRoutesStore)(pinia);
  routesStore.setFullUrl(fullUrl);
  var authStore = (0,_admin_inertia_modules_auth__WEBPACK_IMPORTED_MODULE_0__.useAuthStore)(pinia);
  authStore.setAuthUser(auth.user);
  var articlesStore = (0,_admin_inertia_modules_articles__WEBPACK_IMPORTED_MODULE_1__.useArticlesStore)(pinia);
  articlesStore.setEntities(articles);
  var servicesStore = (0,_admin_inertia_modules_services__WEBPACK_IMPORTED_MODULE_2__.useServicesStore)(pinia);
  servicesStore.setEntities(services);
  var categoriesTreeStore = (0,_admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_3__.useCategoriesTreeStore)(pinia);
  categoriesTreeStore.setEntities(categoriesTree);
  var columnsStore = (0,_admin_inertia_modules_columns__WEBPACK_IMPORTED_MODULE_4__.useColumnsStore)(pinia);
  columnsStore.setAdminOrderColumns(adminOrderColumns);
  columnsStore.setAdminProductColumns(adminProductColumns);
  columnsStore.setAdminProductVariantColumns(adminProductVariantColumns);
  var brandsStore = (0,_admin_inertia_modules_brands__WEBPACK_IMPORTED_MODULE_5__.useBrandsStore)(pinia);
  brandsStore.setOptions(brandOptions);
  var productsStore = (0,_admin_inertia_modules_products__WEBPACK_IMPORTED_MODULE_6__.useProductsStore)(pinia);
  productsStore.setProductListItems(productListItemsData);
  productsStore.setLinks(productListItemsLinks);
  productsStore.setMeta(productListItemsMeta);
  var availabilityStatusesStore = (0,_admin_inertia_modules_availabilityStatuses__WEBPACK_IMPORTED_MODULE_7__.useAvailabilityStatusesStore)(pinia);
  availabilityStatusesStore.setEntities(availabilityStatusesData);
  var billStatusesStore = (0,_admin_inertia_modules_billStatuses__WEBPACK_IMPORTED_MODULE_8__.useBillStatusesStore)(pinia);
  billStatusesStore.setEntities(billStatusesData);
  var currenciesStore = (0,_admin_inertia_modules_currencies__WEBPACK_IMPORTED_MODULE_9__.useCurrenciesStore)(pinia);
  currenciesStore.setEntities(currenciesData);
  var paymentMethodsStore = (0,_admin_inertia_modules_paymentMethods__WEBPACK_IMPORTED_MODULE_10__.usePaymentMethodsStore)(pinia);
  paymentMethodsStore.setEntities(paymentMethodsData);
  var orderImportanceStore = (0,_admin_inertia_modules_orderImportance__WEBPACK_IMPORTED_MODULE_11__.useOrderImportanceStore)(pinia);
  orderImportanceStore.setEntities(orderImportanceData);
  var orderStatusesStore = (0,_admin_inertia_modules_orderStatuses__WEBPACK_IMPORTED_MODULE_12__.useOrderStatusesStore)(pinia);
  orderStatusesStore.setEntities(orderStatusesData);
  var charsStore = (0,_admin_inertia_modules_chars__WEBPACK_IMPORTED_MODULE_13__.useCharsStore)(pinia);
  charsStore.setChartTypes(charTypesData);
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/orderImportance/index.ts":
/*!*********************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/orderImportance/index.ts ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useOrderImportanceStore": () => (/* binding */ useOrderImportanceStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "orderImportance";
var useOrderImportanceStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/orderStatuses/index.ts":
/*!*******************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/orderStatuses/index.ts ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useOrderStatusesStore": () => (/* binding */ useOrderStatusesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "orderStatuses";
var useOrderStatusesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/paymentMethods/index.ts":
/*!********************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/paymentMethods/index.ts ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "usePaymentMethodsStore": () => (/* binding */ usePaymentMethodsStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "paymentMethods";
var usePaymentMethodsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _entities: []
    };
  },
  getters: {
    entities: function entities(state) {
      return state._entities;
    }
  },
  actions: {
    setEntities: function setEntities(entities) {
      this._entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/modules/products/index.ts":
/*!**************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/products/index.ts ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useProductsStore": () => (/* binding */ useProductsStore),
/* harmony export */   "getActiveName": () => (/* binding */ getActiveName),
/* harmony export */   "getPerPageOptions": () => (/* binding */ getPerPageOptions)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_modules_common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/modules/common */ "./resources/js/admin/inertia/modules/common/index.ts");
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");



var storeName = "products";
var useProductsStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _productListItems: [],
      _links: null,
      _meta: null
    };
  },
  getters: {
    productListItems: function productListItems(state) {
      return state._productListItems;
    },
    links: function links(state) {
      return state._links;
    },
    meta: function meta(state) {
      return state._meta;
    },
    getPerPageOption: function getPerPageOption(state) {
      return state._meta && state._meta.per_page ? {
        value: state._meta.per_page,
        label: "".concat(state._meta.per_page)
      } : null;
    }
  },
  actions: {
    setProductListItems: function setProductListItems(productListItems) {
      this._productListItems = productListItems;
    },
    setLinks: function setLinks(links) {
      this._links = links;
    },
    setMeta: function setMeta(meta) {
      var routesStore = (0,_admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_2__.useRoutesStore)();
      this._meta = meta ? (0,_admin_inertia_modules_common__WEBPACK_IMPORTED_MODULE_1__.extendMetaLinksWithComputedData)(meta, routesStore.fullUrl) : null;
    }
  }
});
var getActiveName = function getActiveName(is_active) {
  return is_active ? "Да" : "Нет";
};
var getPerPageOptions = function getPerPageOptions() {
  return [5, 10, 20, 50, 100, 200, 500].map(function (page) {
    return {
      value: page,
      label: "".concat(page)
    };
  });
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/routes/index.ts":
/*!************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/routes/index.ts ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useRoutesStore": () => (/* binding */ useRoutesStore),
/* harmony export */   "routeNames": () => (/* binding */ routeNames),
/* harmony export */   "RouteTypeEnum": () => (/* binding */ RouteTypeEnum),
/* harmony export */   "routeTypes": () => (/* binding */ routeTypes)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/modules/categoriesTree */ "./resources/js/admin/inertia/modules/categoriesTree/index.ts");
/* harmony import */ var ziggy_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ziggy-js */ "ziggy-js");
/* harmony import */ var ziggy_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(ziggy_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _helpers_ziggy__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @/helpers/ziggy */ "./resources/js/helpers/ziggy.js");




var storeName = "routes";
var useRoutesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      _fullUrl: null
    };
  },
  getters: {
    fullUrl: function fullUrl(state) {
      return state._fullUrl;
    },
    isActiveRoute: function isActiveRoute() {
      return function (type) {
        var id = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
        var categoriesTreeStore = (0,_admin_inertia_modules_categoriesTree__WEBPACK_IMPORTED_MODULE_1__.useCategoriesTreeStore)();
        var router = ziggy_js__WEBPACK_IMPORTED_MODULE_2___default()(undefined, undefined, undefined, _helpers_ziggy__WEBPACK_IMPORTED_MODULE_3__.Ziggy);

        switch (type) {
          case RouteTypeEnum.categoriesSub:
          case RouteTypeEnum.categories:
            {
              if (!router.current(RouteNameGroupEnum.Products) && !router.current(RouteNameGroupEnum.Categories)) {
                return false;
              }

              if (id === null) {
                return true;
              }

              var categoryAndSubtreeIds = categoriesTreeStore.getCategoryAndSubtreeIds(id);

              if (!categoryAndSubtreeIds) {
                return false;
              }

              var routeParams = router.params;
              var categoryIdParam = +routeParams.category_id;
              return categoryAndSubtreeIds.includes(categoryIdParam);
            }

          case RouteTypeEnum.reference:
            {
              return router.current(RouteNameGroupEnum.Brands) || router.current(RouteNameGroupEnum.Articles) || router.current(RouteNameGroupEnum.Services) || router.current(RouteNameGroupEnum.Faq) || router.current(RouteNameGroupEnum.Contacts);
            }

          case RouteTypeEnum.referenceBrands:
            {
              return router.current(RouteNameGroupEnum.Brands);
            }

          case RouteTypeEnum.referenceArticles:
            {
              return router.current(RouteNameGroupEnum.Articles);
            }

          case RouteTypeEnum.referenceServices:
            {
              return router.current(RouteNameGroupEnum.Services);
            }

          case RouteTypeEnum.referenceFaq:
            {
              return router.current(RouteNameGroupEnum.Faq);
            }

          case RouteTypeEnum.referenceContacts:
            {
              return router.current(RouteNameGroupEnum.Contacts);
            }

          default:
            {
              return false;
            }
        }
      };
    }
  },
  actions: {
    setFullUrl: function setFullUrl(fullUrl) {
      this._fullUrl = fullUrl;
    }
  }
});
var routeNames = {
  ROUTE_WEB_HOME: "home",
  ROUTE_LOGOUT: "logout",
  ROUTE_ADMIN_HOME: "admin.home",
  ROUTE_ADMIN_MEDIA: "admin.media",
  ROUTE_ADMIN_PRODUCTS_INDEX: "admin.products.index",
  ROUTE_ADMIN_PRODUCTS_CREATE: "admin.products.create",
  ROUTE_ADMIN_PRODUCTS_EDIT: "admin.products.edit",
  ROUTE_ADMIN_PRODUCTS_TEMP_INDEX: "admin.products.temp.index",
  ROUTE_ADMIN_PRODUCTS_TEMP_CREATE: "admin.products.temp.create",
  ROUTE_ADMIN_PRODUCTS_TEMP_EDIT: "admin.products.temp.edit",
  ROUTE_ADMIN_CATEGORIES_INDEX: "admin.categories.index",
  ROUTE_ADMIN_CATEGORIES_CREATE: "admin.categories.create",
  ROUTE_ADMIN_CATEGORIES_EDIT: "admin.categories.edit",
  ROUTE_ADMIN_BRANDS_INDEX: "admin.brands.index",
  ROUTE_ADMIN_BRANDS_CREATE: "admin.brands.create",
  ROUTE_ADMIN_BRANDS_EDIT: "admin.brands.edit",
  ROUTE_ADMIN_ORDERS_INDEX: "admin.orders.index",
  ROUTE_ADMIN_ORDERS_CREATE: "admin.orders.create",
  ROUTE_ADMIN_ORDERS_EDIT: "admin.orders.edit",
  ROUTE_ADMIN_ARTICLES_INDEX: "admin.articles.index",
  ROUTE_ADMIN_ARTICLES_CREATE: "admin.articles.create",
  ROUTE_ADMIN_ARTICLES_EDIT: "admin.articles.edit",
  ROUTE_ADMIN_SERVICES_INDEX: "admin.services.index",
  ROUTE_ADMIN_SERVICES_CREATE: "admin.services.create",
  ROUTE_ADMIN_SERVICES_EDIT: "admin.services.edit",
  ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX: "admin.export-products.index",
  ROUTE_ADMIN_EXPORT_PRODUCTS_SHOW: "admin.export-products.show",
  ROUTE_ADMIN_EXPORT_PRODUCTS_STORE: "admin.export-products.store",
  ROUTE_ADMIN_EXPORT_PRODUCTS_DELETE: "admin.export-products.delete",
  ROUTE_ADMIN_AJAX_SORT_COLUMNS: "admin-ajax.sort-columns"
};
var RouteNameGroupEnum;

(function (RouteNameGroupEnum) {
  RouteNameGroupEnum["Products"] = "admin.products.*";
  RouteNameGroupEnum["Categories"] = "admin.categories.*";
  RouteNameGroupEnum["Brands"] = "admin.brands.*";
  RouteNameGroupEnum["Articles"] = "admin.articles.*";
  RouteNameGroupEnum["Services"] = "admin.services.*";
  RouteNameGroupEnum["Faq"] = "admin.faq.*";
  RouteNameGroupEnum["Contacts"] = "admin.contacts.*";
})(RouteNameGroupEnum || (RouteNameGroupEnum = {}));

var RouteTypeEnum;

(function (RouteTypeEnum) {
  RouteTypeEnum["categoriesSub"] = "categories-sub";
  RouteTypeEnum["categories"] = "categories";
  RouteTypeEnum["reference"] = "reference";
  RouteTypeEnum["referenceBrands"] = "reference-brands";
  RouteTypeEnum["referenceArticles"] = "reference-articles";
  RouteTypeEnum["referenceServices"] = "reference-services";
  RouteTypeEnum["referenceFaq"] = "reference-faq";
  RouteTypeEnum["referenceContacts"] = "reference-contacts";
})(RouteTypeEnum || (RouteTypeEnum = {}));
/**
 * @deprecated use {@link RouteTypeEnum}
 */


var routeTypes = {
  categoriesSub: "categories-sub",
  categories: "categories",
  reference: "reference",
  referenceBrands: "reference-brands",
  referenceArticles: "reference-articles",
  referenceServices: "reference-services",
  referenceFaq: "reference-faq",
  referenceContacts: "reference-contacts"
};

/***/ }),

/***/ "./resources/js/admin/inertia/modules/services/index.ts":
/*!**************************************************************!*\
  !*** ./resources/js/admin/inertia/modules/services/index.ts ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "storeName": () => (/* binding */ storeName),
/* harmony export */   "useServicesStore": () => (/* binding */ useServicesStore)
/* harmony export */ });
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_0__);

var storeName = "services";
var useServicesStore = (0,pinia__WEBPACK_IMPORTED_MODULE_0__.defineStore)(storeName, {
  state: function state() {
    return {
      entities: []
    };
  },
  actions: {
    setEntities: function setEntities(entities) {
      this.entities = entities;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/utils/index.ts":
/*!***************************************************!*\
  !*** ./resources/js/admin/inertia/utils/index.ts ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isNumeric": () => (/* binding */ isNumeric)
/* harmony export */ });
var isNumeric = function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
};

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_shared_layout_TheLayout__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/shared/layout/TheLayout */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue");
/* harmony import */ var _admin_inertia_mixins_routeNames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @/admin/inertia/mixins/routeNames */ "./resources/js/admin/inertia/mixins/routeNames.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! axios */ "axios");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _admin_inertia_mixins_columnNames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/admin/inertia/mixins/columnNames */ "./resources/js/admin/inertia/mixins/columnNames.js");
/* harmony import */ var _admin_inertia_components_FormSearchRow__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/admin/inertia/components/FormSearchRow */ "./resources/js/admin/inertia/components/FormSearchRow.vue");






/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  layout: _admin_inertia_shared_layout_TheLayout__WEBPACK_IMPORTED_MODULE_1__["default"],
  components: {
    Head: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.Head,
    FormSearchRow: _admin_inertia_components_FormSearchRow__WEBPACK_IMPORTED_MODULE_5__["default"]
  },
  mixins: [_admin_inertia_mixins_routeNames__WEBPACK_IMPORTED_MODULE_2__["default"], _admin_inertia_mixins_columnNames__WEBPACK_IMPORTED_MODULE_4__["default"]],
  props: {
    productsPaginated: Object,
    auth: Object,
    adminProductColumns: Array,
    editMode: false,
    selectAll: false,
    columnEnums: Object,
    brandOptions: Array
  },
  data: function data() {
    return {
      sortableColumns: [],
      // Vue.util.extend([], this.adminProductColumns),
      tempSortableColumns: [],
      //Vue.util.extend([], this.adminProductColumns),
      checkedProducts: [],
      sortColumnsEnabled: true,
      modalShow: false,
      products: [] //Vue.util.extend([], this.productsPaginated.data)

    };
  },
  computed: {
    columns: function columns() {
      return this.columnEnums;
    }
  },
  methods: {
    saveSortedColumns: function saveSortedColumns() {
      var _this = this;

      this.sortColumnsEnabled = false;
      axios__WEBPACK_IMPORTED_MODULE_3___default().put(this.route(this.routeNames.ROUTE_ADMIN_AJAX_SORT_COLUMNS), {
        adminProductColumns: this.sortableColumns.map(function (item) {
          return item.value;
        })
      }).then(function () {
        var axiosResponse = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        var _axiosResponse$data$d = axiosResponse.data.data.adminProductColumns,
            adminProductColumns = _axiosResponse$data$d === void 0 ? [] : _axiosResponse$data$d;
        _this.sortableColumns = adminProductColumns;
        _this.tempSortableColumns = []; // Vue.util.extend([], adminProductColumns)
      })["finally"](function () {
        _this.sortColumnsEnabled = true;
        _this.modalShow = false;
      });
    },
    defaultSortedColumns: function defaultSortedColumns() {
      var _this2 = this;

      this.sortColumnsEnabled = false;
      axios__WEBPACK_IMPORTED_MODULE_3___default().put(this.route(this.routeNames.ROUTE_ADMIN_AJAX_SORT_COLUMNS), {
        adminProductColumnsDefault: true
      }).then(function () {
        var axiosResponse = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        var _axiosResponse$data$d2 = axiosResponse.data.data.adminProductColumns,
            adminProductColumns = _axiosResponse$data$d2 === void 0 ? [] : _axiosResponse$data$d2;
        _this2.sortableColumns = adminProductColumns;
        _this2.tempSortableColumns = []; // Vue.util.extend([], adminProductColumns)
      })["finally"](function () {
        _this2.sortColumnsEnabled = true;
        _this2.modalShow = false;
      });
    },
    handleActivation: function handleActivation(id) {},
    handleDelete: function handleDelete(id) {}
  },
  created: function created() {
    console.log('--- productsPaginated', this.productsPaginated);
    console.log('--- auth', this.auth);
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _admin_inertia_mixins_childTypes__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @/admin/inertia/mixins/childTypes */ "./resources/js/admin/inertia/mixins/childTypes.js");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    newRoute: {
      type: String,
      "default": ''
    },
    selected: {
      type: [Object, null],
      "default": null
    },
    options: {
      type: Array,
      "default": function _default() {
        return [];
      }
    },
    prepends: {
      type: Array,
      "default": function _default() {
        return [];
      }
    }
  },
  components: {
    Link: _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_0__.Link
  },
  mixins: [_admin_inertia_mixins_childTypes__WEBPACK_IMPORTED_MODULE_1__["default"]],
  data: function data() {
    return {
      selectedValue: this.selected ? {} : null,
      //  Vue.util.extend({}, this.selected) : null,
      search: ''
    };
  },
  methods: {
    change: function change(type) {
      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
        args[_key - 1] = arguments[_key];
      }

      console.log(type, args);
      this.$emit(type, args);
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__);

function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  _push("<div".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderAttrs)(_attrs), "><div class=\"breadcrumbs\"><a").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderAttr)("href", _ctx.route(_ctx.routeNames.ROUTE_ADMIN_HOME)), " class=\"breadcrumbs__item\"><span class=\"breadcrumbs__text\">\u0420\u0430\u0431\u043E\u0447\u0438\u0439 \u0441\u0442\u043E\u043B</span></a></div><h1 class=\"adm-title\">\u041A\u0430\u0442\u0430\u043B\u043E\u0433 \u0442\u043E\u0432\u0430\u0440\u043E\u0432 <span class=\"adm-fav-link\"></span></h1><!--        <form-search-row :new-route=\"route(routeNames.ROUTE_ADMIN_PRODUCTS_CREATE)\" :options=\"brandOptions\"></form-search-row>--><div><button type=\"button\" class=\"btn btn-primary mb-2 mr-2\">\u041D\u0430\u0441\u0442\u0440\u043E\u0438\u0442\u044C</button></div><div class=\"admin-edit-variations table-responsive\"><table class=\"table table-bordered table-hover\"><thead><tr><th scope=\"col\"><div class=\"form-check form-check-inline\"><input").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrIncludeBooleanAttr)($props.editMode) ? " disabled" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderAttr)("model", $props.selectAll), " class=\"form-check-input position-static\" type=\"checkbox\"></div></th><th scope=\"col\">\xA0</th><!--[-->"));

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderList)($data.sortableColumns, function (sortableColumn) {
    _push("<th scope=\"col\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(sortableColumn.label), "</th>"));
  });

  _push("<!--]--></tr></thead><tbody><!--[-->");

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderList)($data.products, function (product) {
    _push("<tr><td><div class=\"form-check\"><input".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrIncludeBooleanAttr)($props.editMode) ? " disabled" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrIncludeBooleanAttr)(Array.isArray($data.checkedProducts) ? (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrLooseContain)($data.checkedProducts, product.id) : $data.checkedProducts) ? " checked" : "").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderAttr)("value", product.id), " class=\"form-check-input position-static js-product-item-checkbox\" type=\"checkbox\"></div></td><td><!--                            <b-dropdown--><!--                                :id=\"`actions-dropdown-${product.uuid}`\"--><!--                                text=\"\"--><!--                                toggle-class=\"btn btn__grid-row-action-button\"--><!--                                menu-class=\"bx-core-popup-menu\"--><!--                            >--><!--                                <b-dropdown-item :href=\"route(routeNames.ROUTE_ADMIN_PRODUCTS_EDIT, product.id)\" class=\"bx-core-popup-menu-item bx-core-popup-menu-item-default\">--><!--                                    <span class=\"bx-core-popup-menu-item-icon adm-menu-edit\"></span>--><!--                                    <span class=\"bx-core-popup-menu-item-text\">\u0418\u0437\u043C\u0435\u043D\u0438\u0442\u044C</span>--><!--                                </b-dropdown-item>--><!--                                <b-dropdown-item-button @click=\"handleActivation(id)\" class=\"x-core-popup-menu-item\">--><!--                                    <span class=\"bx-core-popup-menu-item-icon\"></span>--><!--                                    <span class=\"bx-core-popup-menu-item-text\">{{product.is_active ? '\u0414\u0435\u0430\u043A\u0442\u0438\u0432\u0438\u0440\u043E\u0432\u0430\u0442\u044C' : '\u0410\u043A\u0442\u0438\u0432\u0438\u0440\u043E\u0432\u0430\u0442\u044C'}}</span>--><!--                                </b-dropdown-item-button>--><!--                                <b-dropdown-divider class=\"bx-core-popup-menu-separator\"></b-dropdown-divider>--><!--                                <b-dropdown-item :href=\"route(routeNames.ROUTE_ADMIN_PRODUCTS_CREATE, {copy_id : product.id})\" class=\"bx-core-popup-menu-item\">--><!--                                    <span class=\"bx-core-popup-menu-item-icon adm-menu-copy\"></span>--><!--                                    <span class=\"bx-core-popup-menu-item-text\">\u041A\u043E\u043F\u0438\u0440\u043E\u0432\u0430\u0442\u044C</span>--><!--                                </b-dropdown-item>--><!--                                <b-dropdown-divider class=\"bx-core-popup-menu-separator\"></b-dropdown-divider>--><!--                                <b-dropdown-item-button @click=\"handleDelete(product.id)\" class=\"x-core-popup-menu-item\">--><!--                                    <span class=\"bx-core-popup-menu-item-icon\"></span>--><!--                                    <span class=\"bx-core-popup-menu-item-text\">\u0423\u0434\u0430\u043B\u0438\u0442\u044C</span>--><!--                                </b-dropdown-item-button>--><!--                            </b-dropdown>--></td><!--[-->"));

    (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrRenderList)($data.sortableColumns, function (sortableColumn) {
      _push("<!--[-->");

      if (sortableColumn.value === _ctx.columnNames.ordering.value) {
        _push("<td><!--                                <b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.ordering\"></b-form-input>--><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.ordering), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.name.value) {
        _push("<td><!--                                <b-form-input v-if=\"editMode && product.is_checked\" v-model=\"product.name\"></b-form-input>--><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.name), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.active.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.is_active_name), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.unit.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.unit), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.price_purchase.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.price_purchase_formatted), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.price_retail.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.price_retail_formatted), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.admin_comment.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.admin_comment), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.availability.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.availability_status_name), "</span></td>"));
      } else {
        _push("<!---->");
      }

      if (sortableColumn.value === _ctx.columnNames.id.value) {
        _push("<td><span class=\"main-grid-cell-content\">".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_0__.ssrInterpolate)(product.id), "</span></td>"));
      } else {
        _push("<!---->");
      }

      _push("<!--]-->");
    });

    _push("<!--]--></tr>");
  });

  _push("<!--]--></tbody></table></div><!-- Modals --><!--        <b-modal--><!--            class=\"modal fade\"--><!--            id=\"customize-list\"--><!--            title=\"\u041D\u0430\u0441\u0442\u0440\u043E\u0439\u043A\u0430 \u0441\u043F\u0438\u0441\u043A\u0430\"--><!--            v-model=\"modalShow\"--><!--        >--><!--            <div class=\"card\">--><!--                <draggable--><!--                    :list=\"tempSortableColumns\"--><!--                    :disabled=\"!sortColumnsEnabled\"--><!--                    class=\"list-group list-group-flush\"--><!--                >--><!--                    <div--><!--                        class=\"list-group-item\"--><!--                        v-for=\"sortableColumn in tempSortableColumns\"--><!--                        :key=\"sortableColumn.value\"--><!--                    >--><!--                        {{ sortableColumn.label }}--><!--                    </div>--><!--                </draggable>--><!--            </div>--><!--            <template #modal-footer>--><!--                <button @click=\"saveSortedColumns\" type=\"button\" class=\"btn btn-primary\">\u0421\u043E\u0445\u0440\u0430\u043D\u0438\u0442\u044C</button>--><!--                <button @click=\"modalShow = false\" type=\"button\" class=\"btn btn-secondary\">\u041E\u0442\u043C\u0435\u043D\u0438\u0442\u044C</button>--><!--                <button @click=\"defaultSortedColumns\" type=\"button\" class=\"btn btn-secondary\">\u0421\u0431\u0440\u043E\u0441\u0438\u0442\u044C</button>--><!--            </template>--><!--        </b-modal>--></div>");
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* binding */ ssrRender)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue/server-renderer */ "vue/server-renderer");
/* harmony import */ var vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);


function ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
  var _component_b_input_group_prepend = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-input-group-prepend");

  var _component_b_button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-button");

  var _component_b_form_input = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-form-input");

  var _component_b_input_group_append = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-input-group-append");

  var _component_b_form_select = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-form-select");

  var _component_b_form_select_option = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("b-form-select-option");

  var _component_Link = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Link");

  _push("<div".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderAttrs)((0,vue__WEBPACK_IMPORTED_MODULE_0__.mergeProps)({
    "class": "search form-group row"
  }, _attrs)), "><div class=\"col-xs-12 col-sm-8\"><div class=\"input-group mb-3\"><!--[-->"));

  (0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderList)($props.prepends, function (prepend) {
    _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_input_group_prepend, {
      key: prepend.label
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
        if (_push) {
          _push("<span style=\"".concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderStyle)({
            "max-width": "200px"
          }), "\" class=\"input-group-text d-inline-block text-truncate\"").concat(_scopeId, ">").concat((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrInterpolate)(prepend.label), "</span>"));

          _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_button, {
            onClick: function onClick($event) {
              return $options.change(_ctx.types.FORM_SEARCH_ROW_PREPEND_CLICK, prepend);
            },
            "class": "btn input-group-prepend__remove"
          }, null, _parent, _scopeId));
        } else {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("span", {
            style: {
              "max-width": "200px"
            },
            "class": "input-group-text d-inline-block text-truncate"
          }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(prepend.label), 1
          /* TEXT */
          ), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_b_button, {
            onClick: function onClick($event) {
              return $options.change(_ctx.types.FORM_SEARCH_ROW_PREPEND_CLICK, prepend);
            },
            "class": "btn input-group-prepend__remove"
          }, null, 8
          /* PROPS */
          , ["onClick"])];
        }
      }),
      _: 2
      /* DYNAMIC */

    }, _parent));
  });

  _push("<!--]-->");

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_form_input, {
    modelValue: $data.search,
    "onUpdate:modelValue": function onUpdateModelValue($event) {
      return $data.search = $event;
    },
    onChange: function onChange($event) {
      return $options.change(_ctx.types.FORM_SEARCH_ROW_ON_SEARCH_CHANGE);
    },
    type: "text",
    placeholder: "Фильтр + поиск",
    "aria-label": "Фильтр + поиск",
    "aria-describedby": "search-button"
  }, null, _parent));

  _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_input_group_append, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
      if (_push) {
        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_button, {
          onClick: function onClick($event) {
            return $options.change(_ctx.types.FORM_SEARCH_ROW_CLEAR_ALL);
          },
          "class": "btn-outline-secondary"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push("<i class=\"fa fa-times\" aria-hidden=\"true\"".concat(_scopeId, "></i>"));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("i", {
                "class": "fa fa-times",
                "aria-hidden": "true"
              })];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));

        _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_button, {
          onClick: function onClick($event) {
            return $options.change(_ctx.types.FORM_SEARCH_ROW_HANDLE_SEARCH);
          },
          "class": "btn-outline-secondary search-icon",
          id: "search-button"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
            if (_push) {
              _push("<i class=\"fa fa-search\" aria-hidden=\"true\"".concat(_scopeId, "></i>"));
            } else {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("i", {
                "class": "fa fa-search",
                "aria-hidden": "true"
              })];
            }
          }),
          _: 1
          /* STABLE */

        }, _parent, _scopeId));
      } else {
        return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_b_button, {
          onClick: function onClick($event) {
            return $options.change(_ctx.types.FORM_SEARCH_ROW_CLEAR_ALL);
          },
          "class": "btn-outline-secondary"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("i", {
              "class": "fa fa-times",
              "aria-hidden": "true"
            })];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["onClick"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_b_button, {
          onClick: function onClick($event) {
            return $options.change(_ctx.types.FORM_SEARCH_ROW_HANDLE_SEARCH);
          },
          "class": "btn-outline-secondary search-icon",
          id: "search-button"
        }, {
          "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
            return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)("i", {
              "class": "fa fa-search",
              "aria-hidden": "true"
            })];
          }),
          _: 1
          /* STABLE */

        }, 8
        /* PROPS */
        , ["onClick"])];
      }
    }),
    _: 1
    /* STABLE */

  }, _parent));

  _push("</div></div>");

  if ($props.options.length) {
    _push("<div class=\"col-xs-12 col-sm-2\">");

    _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_form_select, {
      modelValue: $data.selectedValue,
      "onUpdate:modelValue": function onUpdateModelValue($event) {
        return $data.selectedValue = $event;
      },
      onChange: function onChange($event) {
        return $options.change(_ctx.types.FORM_SEARCH_ROW_SELECT_VALUE);
      },
      options: $props.options,
      "value-field": "value",
      "text-field": "label"
    }, {
      first: (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
        if (_push) {
          _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_b_form_select_option, {
            value: null
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
              if (_push) {
                _push("\u041F\u0440\u043E\u0438\u0437\u0432\u043E\u0434\u0438\u0442\u0435\u043B\u044C");
              } else {
                return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Производитель")];
              }
            }),
            _: 1
            /* STABLE */

          }, _parent, _scopeId));
        } else {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_b_form_select_option, {
            value: null
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Производитель")];
            }),
            _: 1
            /* STABLE */

          })];
        }
      }),
      _: 1
      /* STABLE */

    }, _parent));

    _push("</div>");
  } else {
    _push("<!---->");
  }

  if ($props.newRoute) {
    _push("<div class=\"col-xs-12 col-sm-2\"><div class=\"dropdown\">");

    _push((0,vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.ssrRenderComponent)(_component_Link, {
      href: $props.newRoute,
      "class": "btn btn-add btn-secondary"
    }, {
      "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function (_, _push, _parent, _scopeId) {
        if (_push) {
          _push("\u0421\u043E\u0437\u0434\u0430\u0442\u044C");
        } else {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)("Создать")];
        }
      }),
      _: 1
      /* STABLE */

    }, _parent));

    _push("</div></div>");
  } else {
    _push("<!---->");
  }

  _push("</div>");
}

/***/ }),

/***/ "./resources/js/admin/inertia/mixins/childTypes.js":
/*!*********************************************************!*\
  !*** ./resources/js/admin/inertia/mixins/childTypes.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      types: {
        FORM_SEARCH_ROW_PREPEND_CLICK: 1,
        FORM_SEARCH_ROW_ON_SEARCH_CHANGE: 2,
        FORM_SEARCH_ROW_CLEAR_ALL: 3,
        FORM_SEARCH_ROW_HANDLE_SEARCH: 4,
        FORM_SEARCH_ROW_SELECT_VALUE: 5
      }
    };
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/mixins/columnNames.js":
/*!**********************************************************!*\
  !*** ./resources/js/admin/inertia/mixins/columnNames.js ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      /**
       * @see src/Domain/Common/Enums/Column.php
       */
      columnNames: {
        id: {
          value: 1,
          label: "ID"
        },
        name: {
          value: 2,
          label: "Имя"
        },
        date_creation: {
          value: 3,
          label: "Дата создания"
        },
        status: {
          value: 4,
          label: "Статус"
        },
        positions: {
          value: 5,
          label: "Позиции"
        },
        comment_admin: {
          value: 6,
          label: "Комментарии"
        },
        importance: {
          value: 7,
          label: "Важность"
        },
        manager: {
          value: 8,
          label: "Менеджер"
        },
        sum: {
          value: 9,
          label: "Сумма"
        },
        phone: {
          value: 10,
          label: "Телефон"
        },
        email: {
          value: 11,
          label: "Email"
        },
        comment_user: {
          value: 12,
          label: "Комментарий покупателя"
        },
        payment_method: {
          value: 13,
          label: "Платежная система"
        },
        unit: {
          value: 14,
          label: "Упаковка"
        },
        price_purchase: {
          value: 15,
          label: "Закупочная"
        },
        price_retail: {
          value: 16,
          label: "Розничная"
        },
        admin_comment: {
          value: 17,
          label: "Служебная Информация"
        },
        availability: {
          value: 18,
          label: "Наличие"
        },
        active: {
          value: 19,
          label: "Акт-ть"
        },
        detailed_image: {
          value: 20,
          label: "Детальная картинка"
        },
        additional_images: {
          value: 21,
          label: "Дополнительные фото"
        },
        ordering: {
          value: 22,
          label: "Сорт-ка"
        },
        coefficient: {
          value: 23,
          label: "Коэффициент"
        },
        coefficient_description: {
          value: 24,
          label: "Описание коэффициента"
        }
      }
    };
  }
});

/***/ }),

/***/ "./resources/js/admin/inertia/mixins/routeNames.js":
/*!*********************************************************!*\
  !*** ./resources/js/admin/inertia/mixins/routeNames.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @/admin/inertia/modules/routes */ "./resources/js/admin/inertia/modules/routes/index.ts");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  computed: {
    routeNames: function routeNames() {
      /**
       * @see src/App/Constants.php
       */
      return _objectSpread({}, _admin_inertia_modules_routes__WEBPACK_IMPORTED_MODULE_0__.routeNames);
    }
  }
});

/***/ }),

/***/ "./resources/js/helpers/ziggy.js":
/*!***************************************!*\
  !*** ./resources/js/helpers/ziggy.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Ziggy": () => (/* binding */ Ziggy)
/* harmony export */ });
var Ziggy = {
  url: "http://mpl.localhost",
  port: null,
  defaults: {},
  routes: {
    "debugbar.openhandler": {
      uri: "_debugbar/open",
      methods: ["GET", "HEAD"]
    },
    "debugbar.clockwork": {
      uri: "_debugbar/clockwork/{id}",
      methods: ["GET", "HEAD"]
    },
    "debugbar.assets.css": {
      uri: "_debugbar/assets/stylesheets",
      methods: ["GET", "HEAD"]
    },
    "debugbar.assets.js": {
      uri: "_debugbar/assets/javascript",
      methods: ["GET", "HEAD"]
    },
    "debugbar.cache.delete": {
      uri: "_debugbar/cache/{key}/{tags?}",
      methods: ["DELETE"]
    },
    "livewire.message": {
      uri: "livewire/message/{name}",
      methods: ["POST"]
    },
    "livewire.upload-file": {
      uri: "livewire/upload-file",
      methods: ["POST"]
    },
    "livewire.preview-file": {
      uri: "livewire/preview-file/{filename}",
      methods: ["GET", "HEAD"]
    },
    "admin.home": {
      uri: "admin/home",
      methods: ["GET", "HEAD"]
    },
    "admin.media": {
      uri: "admin/media/{id}/{name?}",
      methods: ["GET", "HEAD"]
    },
    "admin.products.index": {
      uri: "admin/products",
      methods: ["GET", "HEAD"]
    },
    "admin.products.temp.index": {
      uri: "admin/temp-products",
      methods: ["GET", "HEAD"]
    },
    "admin.products.create": {
      uri: "admin/products/create",
      methods: ["GET", "HEAD"]
    },
    "admin.products.edit": {
      uri: "admin/products/{admin_product}/edit",
      methods: ["GET", "HEAD"]
    },
    "admin.categories.index": {
      uri: "admin/categories",
      methods: ["GET", "HEAD"]
    },
    "admin.categories.create": {
      uri: "admin/categories/create",
      methods: ["GET", "HEAD"]
    },
    "admin.categories.edit": {
      uri: "admin/categories/{admin_category}/edit",
      methods: ["GET", "HEAD"]
    },
    "admin.brands.index": {
      uri: "admin/brands",
      methods: ["GET", "HEAD"]
    },
    "admin.brands.create": {
      uri: "admin/brands/create",
      methods: ["GET", "HEAD"]
    },
    "admin.brands.edit": {
      uri: "admin/brands/{admin_brand}/edit",
      methods: ["GET", "HEAD"]
    },
    "admin.orders.index": {
      uri: "admin/orders",
      methods: ["GET", "HEAD"]
    },
    "admin.orders.create": {
      uri: "admin/orders/create",
      methods: ["GET", "HEAD"]
    },
    "admin.orders.edit": {
      uri: "admin/orders/{admin_order}/edit",
      methods: ["GET", "HEAD"]
    },
    "admin.export-products.index": {
      uri: "admin/export-products",
      methods: ["GET", "HEAD"]
    },
    "admin.export-products.show": {
      uri: "admin/export-products/{id}",
      methods: ["GET", "HEAD"]
    },
    "admin.export-products.store": {
      uri: "admin/export-products",
      methods: ["POST"]
    },
    "admin.export-products.delete": {
      uri: "admin/export-products/{id}",
      methods: ["DELETE"]
    },
    "admin.articles.index": {
      uri: "admin/articles",
      methods: ["GET", "HEAD"]
    },
    "admin.services.index": {
      uri: "admin/services",
      methods: ["GET", "HEAD"]
    },
    "admin-ajax.profile.update": {
      uri: "admin-ajax/profiles/{admin}",
      methods: ["PUT"]
    },
    "admin-ajax.show-order-busy": {
      uri: "admin-ajax/show-order-busy",
      methods: ["POST"]
    },
    "admin-ajax.ping-order-busy": {
      uri: "admin-ajax/ping-order-busy/{id}",
      methods: ["POST"]
    },
    "admin-ajax.sort-columns": {
      uri: "admin-ajax/sort-columns",
      methods: ["PUT"]
    },
    test: {
      uri: "---test/{id?}/{hash?}",
      methods: ["GET", "HEAD"]
    },
    login: {
      uri: "login",
      methods: ["GET", "HEAD"]
    },
    logout: {
      uri: "logout",
      methods: ["POST"]
    },
    "password.request": {
      uri: "password/reset",
      methods: ["GET", "HEAD"]
    },
    "password.email": {
      uri: "password/email",
      methods: ["POST"]
    },
    "password.reset": {
      uri: "password/reset/{token}",
      methods: ["GET", "HEAD"]
    },
    "password.update": {
      uri: "password/reset",
      methods: ["POST"]
    },
    "product.show.1": {
      uri: "catalog/{category_slug}/{product_slug}.html",
      methods: ["GET", "HEAD"]
    },
    "product.show.2": {
      uri: "catalog/{category_slug}/{subcategory1_slug}/{product_slug}.html",
      methods: ["GET", "HEAD"]
    },
    "product.show.3": {
      uri: "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{product_slug}.html",
      methods: ["GET", "HEAD"]
    },
    "product.show.4": {
      uri: "catalog/{category_slug}/{subcategory1_slug}/{subcategory2_slug}/{subcategory3_slug}/{product_slug}.html",
      methods: ["GET", "HEAD"]
    },
    "products.index": {
      uri: "catalog/{category_slug?}/{subcategory1_slug?}/{subcategory2_slug?}/{subcategory3_slug?}",
      methods: ["GET", "HEAD"]
    },
    "brands.index": {
      uri: "brands",
      methods: ["GET", "HEAD"]
    },
    "brands.show": {
      uri: "brands/{brand_slug}.html",
      methods: ["GET", "HEAD"]
    },
    "gallery.items.index": {
      uri: "photos",
      methods: ["GET", "HEAD"]
    },
    "gallery.items.show": {
      uri: "photos/{parentGalleryItemSlug}",
      methods: ["GET", "HEAD"]
    },
    "articles.show": {
      uri: "articles/{article_slug}/{subarticle_slug?}",
      methods: ["GET", "HEAD"]
    },
    "faq.index": {
      uri: "faq",
      methods: ["GET", "HEAD"]
    },
    "faq.show": {
      uri: "faq/{faq_slug}",
      methods: ["GET", "HEAD"]
    },
    ask: {
      uri: "ask",
      methods: ["GET", "HEAD"]
    },
    "videos.index": {
      uri: "videos",
      methods: ["GET", "HEAD"]
    },
    howto: {
      uri: "howto",
      methods: ["GET", "HEAD"]
    },
    delivery: {
      uri: "delivery",
      methods: ["GET", "HEAD"]
    },
    "return": {
      uri: "return",
      methods: ["GET", "HEAD"]
    },
    contacts: {
      uri: "contacts",
      methods: ["GET", "HEAD"]
    },
    viewed: {
      uri: "viewed",
      methods: ["GET", "HEAD"]
    },
    aside: {
      uri: "aside",
      methods: ["GET", "HEAD"]
    },
    "cart.show": {
      uri: "cart",
      methods: ["GET", "HEAD"]
    },
    "cart.success": {
      uri: "cart-success/{order_id}",
      methods: ["GET", "HEAD"]
    },
    "cart.checkout": {
      uri: "cart-checkout",
      methods: ["POST"]
    },
    profile: {
      uri: "profile",
      methods: ["GET", "HEAD"]
    },
    "orders.show": {
      uri: "orders/{id}",
      methods: ["GET", "HEAD"]
    },
    "profile.identify": {
      uri: "profile-identify/{id}/{email}/{hash}",
      methods: ["GET", "HEAD"]
    },
    media: {
      uri: "media/{id}/{name?}",
      methods: ["GET", "HEAD"]
    },
    "services.show": {
      uri: "{service_slug}",
      methods: ["GET", "HEAD"]
    },
    home: {
      uri: "/",
      methods: ["GET", "HEAD"]
    },
    "ajax.products.aside.store": {
      uri: "ajax/products/aside",
      methods: ["POST"]
    },
    "ajax.products.aside.delete": {
      uri: "ajax/products/aside",
      methods: ["DELETE"]
    },
    "ajax.products.cart.index": {
      uri: "ajax/products/cart",
      methods: ["GET", "HEAD"]
    },
    "ajax.products.cart.store": {
      uri: "ajax/products/cart",
      methods: ["POST"]
    },
    "ajax.products.cart.update": {
      uri: "ajax/products/cart",
      methods: ["PUT"]
    },
    "ajax.products.cart.delete": {
      uri: "ajax/products/cart",
      methods: ["DELETE"]
    },
    "ajax.orders.update": {
      uri: "ajax/orders/{id}",
      methods: ["POST"]
    }
  }
};

if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}



/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";

Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Articles/Index.vue":
/*!*************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Articles/Index.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_69f5de3e_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=69f5de3e&ts=true */ "./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true");
/* harmony import */ var _Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_Index_vue_vue_type_template_id_69f5de3e_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/Pages/Articles/Index.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index.vue":
/*!*************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_90754eb6_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=90754eb6&ts=true */ "./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true");
/* harmony import */ var _Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_Index_vue_vue_type_template_id_90754eb6_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/Pages/Products/Index.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index2.vue":
/*!**************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index2.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index2_vue_vue_type_template_id_40fd655d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index2.vue?vue&type=template&id=40fd655d */ "./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d");
/* harmony import */ var _Index2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index2.vue?vue&type=script&lang=js */ "./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_Index2_vue_vue_type_template_id_40fd655d__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/Pages/Products/Index2.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Services/Index.vue":
/*!*************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Services/Index.vue ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Index_vue_vue_type_template_id_4da0b1c2_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Index.vue?vue&type=template&id=4da0b1c2&ts=true */ "./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true");
/* harmony import */ var _Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Index.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_Index_vue_vue_type_template_id_4da0b1c2_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/Pages/Services/Index.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/components/FormSearchRow.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/admin/inertia/components/FormSearchRow.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormSearchRow_vue_vue_type_template_id_4f1e46c8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormSearchRow.vue?vue&type=template&id=4f1e46c8 */ "./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8");
/* harmony import */ var _FormSearchRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormSearchRow.vue?vue&type=script&lang=js */ "./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_FormSearchRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_FormSearchRow_vue_vue_type_template_id_4f1e46c8__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/components/FormSearchRow.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue":
/*!***********************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/forms/FormControlSelect.vue ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _FormControlSelect_vue_vue_type_template_id_0f8f70de_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true */ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true");
/* harmony import */ var _FormControlSelect_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FormControlSelect.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_FormControlSelect_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_FormControlSelect_vue_vue_type_template_id_0f8f70de_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/forms/FormControlSelect.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/NavItem.vue":
/*!**************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/NavItem.vue ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _NavItem_vue_vue_type_template_id_3f813950_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NavItem.vue?vue&type=template&id=3f813950&ts=true */ "./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true");
/* harmony import */ var _NavItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NavItem.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_NavItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_NavItem_vue_vue_type_template_id_3f813950_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/NavItem.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/PageItem.vue":
/*!***************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/PageItem.vue ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _PageItem_vue_vue_type_template_id_8acbd7a0_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./PageItem.vue?vue&type=template&id=8acbd7a0&ts=true */ "./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true");
/* harmony import */ var _PageItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PageItem.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_PageItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_PageItem_vue_vue_type_template_id_8acbd7a0_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/PageItem.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/Pagination.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/Pagination.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Pagination_vue_vue_type_template_id_63169ff0_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Pagination.vue?vue&type=template&id=63169ff0&ts=true */ "./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true");
/* harmony import */ var _Pagination_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Pagination.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Pagination_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_Pagination_vue_vue_type_template_id_63169ff0_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/Pagination.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheHeader.vue":
/*!****************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheHeader.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TheHeader_vue_vue_type_template_id_15699740_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheHeader.vue?vue&type=template&id=15699740&ts=true */ "./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true");
/* harmony import */ var _TheHeader_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheHeader.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TheHeader_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_TheHeader_vue_vue_type_template_id_15699740_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/TheHeader.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheLayout.vue":
/*!****************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheLayout.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TheLayout_vue_vue_type_template_id_d86c9306_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheLayout.vue?vue&type=template&id=d86c9306&ts=true */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true");
/* harmony import */ var _TheLayout_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheLayout.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TheLayout_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_TheLayout_vue_vue_type_template_id_d86c9306_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/TheLayout.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue":
/*!*****************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheSidebar.vue ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _TheSidebar_vue_vue_type_template_id_57abb999_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TheSidebar.vue?vue&type=template&id=57abb999&ts=true */ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true");
/* harmony import */ var _TheSidebar_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TheSidebar.vue?vue&type=script&lang=ts&setup=true */ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true");
/* harmony import */ var _var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,_var_www_html_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_TheSidebar_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_1__["default"], [['ssrRender',_TheSidebar_vue_vue_type_template_id_57abb999_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender],['__file',"resources/js/admin/inertia/shared/layout/TheSidebar.vue"]])

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true":
/*!************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true":
/*!************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true":
/*!************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true ***!
  \************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true":
/*!**********************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true ***!
  \**********************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormControlSelect_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormControlSelect_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./FormControlSelect.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true":
/*!*************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true ***!
  \*************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NavItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NavItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NavItem.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true":
/*!**************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true ***!
  \**************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PageItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PageItem_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PageItem.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true":
/*!****************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Pagination.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true":
/*!***************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheHeader_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheHeader_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheHeader.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true":
/*!***************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheLayout_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheLayout_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheLayout.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true":
/*!****************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheSidebar_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheSidebar_vue_vue_type_script_lang_ts_setup_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheSidebar.vue?vue&type=script&lang=ts&setup=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=script&lang=ts&setup=true");
 

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true":
/*!***************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_69f5de3e_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_69f5de3e_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=template&id=69f5de3e&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Articles/Index.vue?vue&type=template&id=69f5de3e&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true":
/*!***************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_90754eb6_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_90754eb6_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=template&id=90754eb6&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index.vue?vue&type=template&id=90754eb6&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true":
/*!***************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true ***!
  \***************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_4da0b1c2_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index_vue_vue_type_template_id_4da0b1c2_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index.vue?vue&type=template&id=4da0b1c2&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Services/Index.vue?vue&type=template&id=4da0b1c2&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true":
/*!*************************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true ***!
  \*************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormControlSelect_vue_vue_type_template_id_0f8f70de_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormControlSelect_vue_vue_type_template_id_0f8f70de_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/forms/FormControlSelect.vue?vue&type=template&id=0f8f70de&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true":
/*!****************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true ***!
  \****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NavItem_vue_vue_type_template_id_3f813950_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_NavItem_vue_vue_type_template_id_3f813950_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./NavItem.vue?vue&type=template&id=3f813950&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/NavItem.vue?vue&type=template&id=3f813950&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true":
/*!*****************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true ***!
  \*****************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PageItem_vue_vue_type_template_id_8acbd7a0_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_PageItem_vue_vue_type_template_id_8acbd7a0_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./PageItem.vue?vue&type=template&id=8acbd7a0&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/PageItem.vue?vue&type=template&id=8acbd7a0&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_63169ff0_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Pagination_vue_vue_type_template_id_63169ff0_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Pagination.vue?vue&type=template&id=63169ff0&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/Pagination.vue?vue&type=template&id=63169ff0&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true":
/*!******************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheHeader_vue_vue_type_template_id_15699740_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheHeader_vue_vue_type_template_id_15699740_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheHeader.vue?vue&type=template&id=15699740&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheHeader.vue?vue&type=template&id=15699740&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true":
/*!******************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true ***!
  \******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheLayout_vue_vue_type_template_id_d86c9306_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheLayout_vue_vue_type_template_id_d86c9306_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheLayout.vue?vue&type=template&id=d86c9306&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheLayout.vue?vue&type=template&id=d86c9306&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true":
/*!*******************************************************************************************************!*\
  !*** ./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true ***!
  \*******************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheSidebar_vue_vue_type_template_id_57abb999_ts_true__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_ts_loader_index_js_clonedRuleSet_21_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_TheSidebar_vue_vue_type_template_id_57abb999_ts_true__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/ts-loader/index.js??clonedRuleSet-21!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./TheSidebar.vue?vue&type=template&id=57abb999&ts=true */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/ts-loader/index.js??clonedRuleSet-21!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/shared/layout/TheSidebar.vue?vue&type=template&id=57abb999&ts=true");


/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js":
/*!**************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js ***!
  \**************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index2_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index2.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js":
/*!*****************************************************************************************!*\
  !*** ./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormSearchRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormSearchRow_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./FormSearchRow.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d":
/*!********************************************************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d ***!
  \********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index2_vue_vue_type_template_id_40fd655d__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Index2_vue_vue_type_template_id_40fd655d__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Index2.vue?vue&type=template&id=40fd655d */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/Pages/Products/Index2.vue?vue&type=template&id=40fd655d");


/***/ }),

/***/ "./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8":
/*!***********************************************************************************************!*\
  !*** ./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8 ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ssrRender": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormSearchRow_vue_vue_type_template_id_4f1e46c8__WEBPACK_IMPORTED_MODULE_0__.ssrRender)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_3_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_FormSearchRow_vue_vue_type_template_id_4f1e46c8__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!../../../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./FormSearchRow.vue?vue&type=template&id=4f1e46c8 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[3]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/admin/inertia/components/FormSearchRow.vue?vue&type=template&id=4f1e46c8");


/***/ }),

/***/ "./resources/js/admin/inertia/Pages sync recursive ^\\.\\/.*$":
/*!*********************************************************!*\
  !*** ./resources/js/admin/inertia/Pages/ sync ^\.\/.*$ ***!
  \*********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./Articles/Index": "./resources/js/admin/inertia/Pages/Articles/Index.vue",
	"./Articles/Index.vue": "./resources/js/admin/inertia/Pages/Articles/Index.vue",
	"./Products/Index": "./resources/js/admin/inertia/Pages/Products/Index.vue",
	"./Products/Index.vue": "./resources/js/admin/inertia/Pages/Products/Index.vue",
	"./Products/Index2": "./resources/js/admin/inertia/Pages/Products/Index2.vue",
	"./Products/Index2.vue": "./resources/js/admin/inertia/Pages/Products/Index2.vue",
	"./Services/Index": "./resources/js/admin/inertia/Pages/Services/Index.vue",
	"./Services/Index.vue": "./resources/js/admin/inertia/Pages/Services/Index.vue"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./resources/js/admin/inertia/Pages sync recursive ^\\.\\/.*$";

/***/ }),

/***/ "@inertiajs/inertia-vue3":
/*!******************************************!*\
  !*** external "@inertiajs/inertia-vue3" ***!
  \******************************************/
/***/ ((module) => {

"use strict";
module.exports = require("@inertiajs/inertia-vue3");

/***/ }),

/***/ "@inertiajs/server":
/*!************************************!*\
  !*** external "@inertiajs/server" ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = require("@inertiajs/server");

/***/ }),

/***/ "@vue/server-renderer":
/*!***************************************!*\
  !*** external "@vue/server-renderer" ***!
  \***************************************/
/***/ ((module) => {

"use strict";
module.exports = require("@vue/server-renderer");

/***/ }),

/***/ "@vueuse/core":
/*!*******************************!*\
  !*** external "@vueuse/core" ***!
  \*******************************/
/***/ ((module) => {

"use strict";
module.exports = require("@vueuse/core");

/***/ }),

/***/ "axios":
/*!************************!*\
  !*** external "axios" ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = require("axios");

/***/ }),

/***/ "pinia":
/*!************************!*\
  !*** external "pinia" ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = require("pinia");

/***/ }),

/***/ "vue":
/*!**********************!*\
  !*** external "vue" ***!
  \**********************/
/***/ ((module) => {

"use strict";
module.exports = require("vue");

/***/ }),

/***/ "vue/server-renderer":
/*!**************************************!*\
  !*** external "vue/server-renderer" ***!
  \**************************************/
/***/ ((module) => {

"use strict";
module.exports = require("vue/server-renderer");

/***/ }),

/***/ "ziggy-js":
/*!***************************!*\
  !*** external "ziggy-js" ***!
  \***************************/
/***/ ((module) => {

"use strict";
module.exports = require("ziggy-js");

/***/ }),

/***/ "ziggy-js/dist/vue":
/*!************************************!*\
  !*** external "ziggy-js/dist/vue" ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = require("ziggy-js/dist/vue");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*******************************************!*\
  !*** ./resources/js/admin/inertia/ssr.js ***!
  \*******************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @vue/server-renderer */ "@vue/server-renderer");
/* harmony import */ var _vue_server_renderer__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @inertiajs/inertia-vue3 */ "@inertiajs/inertia-vue3");
/* harmony import */ var _inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _inertiajs_server__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @inertiajs/server */ "@inertiajs/server");
/* harmony import */ var _inertiajs_server__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_server__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var ziggy_js_dist_vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ziggy-js/dist/vue */ "ziggy-js/dist/vue");
/* harmony import */ var ziggy_js_dist_vue__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(ziggy_js_dist_vue__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _helpers_ziggy__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/helpers/ziggy */ "./resources/js/helpers/ziggy.js");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! pinia */ "pinia");
/* harmony import */ var pinia__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(pinia__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _admin_inertia_modules__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/admin/inertia/modules */ "./resources/js/admin/inertia/modules/index.ts");








_inertiajs_server__WEBPACK_IMPORTED_MODULE_3___default()(function (page) {
  return (0,_inertiajs_inertia_vue3__WEBPACK_IMPORTED_MODULE_2__.createInertiaApp)({
    page: page,
    render: _vue_server_renderer__WEBPACK_IMPORTED_MODULE_1__.renderToString,
    resolve: function resolve(name) {
      return __webpack_require__("./resources/js/admin/inertia/Pages sync recursive ^\\.\\/.*$")("./".concat(name));
    },
    setup: function setup(_ref) {
      var app = _ref.app,
          props = _ref.props,
          plugin = _ref.plugin;
      var pinia = (0,pinia__WEBPACK_IMPORTED_MODULE_6__.createPinia)();

      try {
        return (0,vue__WEBPACK_IMPORTED_MODULE_0__.createSSRApp)({
          render: function render() {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.h)(app, props);
          }
        }).use(plugin).use(ziggy_js_dist_vue__WEBPACK_IMPORTED_MODULE_4__.ZiggyVue, _helpers_ziggy__WEBPACK_IMPORTED_MODULE_5__.Ziggy).use(pinia); // walkaround for passing page props to pinia
      } finally {
        var _props$initialPage;

        (0,_admin_inertia_modules__WEBPACK_IMPORTED_MODULE_7__.initFromPageProps)(pinia, props === null || props === void 0 ? void 0 : (_props$initialPage = props.initialPage) === null || _props$initialPage === void 0 ? void 0 : _props$initialPage.props);
      }
    }
  });
});
})();

/******/ })()
;