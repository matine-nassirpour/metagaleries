"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["contact"],{

/***/ "./assets/scripts/contact.js":
/*!***********************************!*\
  !*** ./assets/scripts/contact.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_1__);
/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");


$('#contactForm').submit(function (e) {
  var form = this;
  e.preventDefault();
  setTimeout(function () {
    form.submit();
  }, 3500); // in milliseconds

  sweetalert2__WEBPACK_IMPORTED_MODULE_1___default().fire({
    position: 'top-end',
    icon: 'success',
    title: 'Votre message a bien été envoyé.',
    text: 'Nous vous répondons dans les meilleurs délais.',
    showConfirmButton: false,
    timer: 4500
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_internals_export_js","vendors-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_modules_web_timers_js-node_modules_sweetalert2_dist_sweetalert2_all_js"], () => (__webpack_exec__("./assets/scripts/contact.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiY29udGFjdC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFFQUMsQ0FBQyxDQUFDLGNBQUQsQ0FBRCxDQUFrQkMsTUFBbEIsQ0FBeUIsVUFBVUMsQ0FBVixFQUFhO0FBQ2xDLE1BQUlDLElBQUksR0FBRyxJQUFYO0FBQ0FELEVBQUFBLENBQUMsQ0FBQ0UsY0FBRjtBQUVBQyxFQUFBQSxVQUFVLENBQUMsWUFBWTtBQUNuQkYsSUFBQUEsSUFBSSxDQUFDRixNQUFMO0FBQ0gsR0FGUyxFQUVQLElBRk8sQ0FBVixDQUprQyxDQU14Qjs7QUFFVkYsRUFBQUEsdURBQUEsQ0FBVTtBQUNOUSxJQUFBQSxRQUFRLEVBQUUsU0FESjtBQUVOQyxJQUFBQSxJQUFJLEVBQUUsU0FGQTtBQUdOQyxJQUFBQSxLQUFLLEVBQUUsa0NBSEQ7QUFJTkMsSUFBQUEsSUFBSSxFQUFFLGdEQUpBO0FBS05DLElBQUFBLGlCQUFpQixFQUFFLEtBTGI7QUFNTkMsSUFBQUEsS0FBSyxFQUFFO0FBTkQsR0FBVjtBQVFILENBaEJEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL3NjcmlwdHMvY29udGFjdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgU3dhbCBmcm9tICdzd2VldGFsZXJ0Mic7XHJcblxyXG4kKCcjY29udGFjdEZvcm0nKS5zdWJtaXQoZnVuY3Rpb24gKGUpIHtcclxuICAgIGxldCBmb3JtID0gdGhpcztcclxuICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuXHJcbiAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBmb3JtLnN1Ym1pdCgpO1xyXG4gICAgfSwgMzUwMCk7IC8vIGluIG1pbGxpc2Vjb25kc1xyXG5cclxuICAgIFN3YWwuZmlyZSh7XHJcbiAgICAgICAgcG9zaXRpb246ICd0b3AtZW5kJyxcclxuICAgICAgICBpY29uOiAnc3VjY2VzcycsXHJcbiAgICAgICAgdGl0bGU6ICdWb3RyZSBtZXNzYWdlIGEgYmllbiDDqXTDqSBlbnZvecOpLicsXHJcbiAgICAgICAgdGV4dDogJ05vdXMgdm91cyByw6lwb25kb25zIGRhbnMgbGVzIG1laWxsZXVycyBkw6lsYWlzLicsXHJcbiAgICAgICAgc2hvd0NvbmZpcm1CdXR0b246IGZhbHNlLFxyXG4gICAgICAgIHRpbWVyOiA0NTAwXHJcbiAgICB9KVxyXG59KTtcclxuIl0sIm5hbWVzIjpbIlN3YWwiLCIkIiwic3VibWl0IiwiZSIsImZvcm0iLCJwcmV2ZW50RGVmYXVsdCIsInNldFRpbWVvdXQiLCJmaXJlIiwicG9zaXRpb24iLCJpY29uIiwidGl0bGUiLCJ0ZXh0Iiwic2hvd0NvbmZpcm1CdXR0b24iLCJ0aW1lciJdLCJzb3VyY2VSb290IjoiIn0=