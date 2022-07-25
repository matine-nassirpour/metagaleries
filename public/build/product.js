"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["product"],{

/***/ "./assets/scripts/product.js":
/*!***********************************!*\
  !*** ./assets/scripts/product.js ***!
  \***********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var js_image_zoom__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! js-image-zoom */ "./node_modules/js-image-zoom/js-image-zoom.js");
/* harmony import */ var js_image_zoom__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(js_image_zoom__WEBPACK_IMPORTED_MODULE_0__);

var isDesktopScreen = window.innerWidth >= 1024;

if (isDesktopScreen) {
  var options = {
    zoomPosition: 'original'
  };
  new (js_image_zoom__WEBPACK_IMPORTED_MODULE_0___default())(document.getElementById('img-container'), options);
}

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_js-image-zoom_js-image-zoom_js"], () => (__webpack_exec__("./assets/scripts/product.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoicHJvZHVjdC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7QUFBQTtBQUVBLElBQU1DLGVBQWUsR0FBR0MsTUFBTSxDQUFDQyxVQUFQLElBQXFCLElBQTdDOztBQUVBLElBQUlGLGVBQUosRUFBcUI7QUFDakIsTUFBSUcsT0FBTyxHQUFHO0FBQ1ZDLElBQUFBLFlBQVksRUFBRTtBQURKLEdBQWQ7QUFJQSxNQUFJTCxzREFBSixDQUFjTSxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsZUFBeEIsQ0FBZCxFQUF3REgsT0FBeEQ7QUFDSCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL2Fzc2V0cy9zY3JpcHRzL3Byb2R1Y3QuanMiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IEltYWdlWm9vbSBmcm9tICdqcy1pbWFnZS16b29tJztcclxuXHJcbmNvbnN0IGlzRGVza3RvcFNjcmVlbiA9IHdpbmRvdy5pbm5lcldpZHRoID49IDEwMjQ7XHJcblxyXG5pZiAoaXNEZXNrdG9wU2NyZWVuKSB7XHJcbiAgICB2YXIgb3B0aW9ucyA9IHtcclxuICAgICAgICB6b29tUG9zaXRpb246ICdvcmlnaW5hbCcsXHJcbiAgICB9O1xyXG5cclxuICAgIG5ldyBJbWFnZVpvb20oZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltZy1jb250YWluZXInKSwgb3B0aW9ucyk7XHJcbn1cclxuXHJcbiJdLCJuYW1lcyI6WyJJbWFnZVpvb20iLCJpc0Rlc2t0b3BTY3JlZW4iLCJ3aW5kb3ciLCJpbm5lcldpZHRoIiwib3B0aW9ucyIsInpvb21Qb3NpdGlvbiIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiXSwic291cmNlUm9vdCI6IiJ9