/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/build-from-scratch.png":
/*!**************************************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/build-from-scratch.png ***!
  \**************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/build-from-scratch.a69c9e58.png";

/***/ }),

/***/ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/customize-each-block.png":
/*!****************************************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/customize-each-block.png ***!
  \****************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/customize-each-block.cb8cf063.png";

/***/ }),

/***/ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/documentation.png":
/*!*********************************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/documentation.png ***!
  \*********************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/documentation.ae5798e5.png";

/***/ }),

/***/ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/how-to-use.png":
/*!******************************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/how-to-use.png ***!
  \******************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/how-to-use.7e873f57.png";

/***/ }),

/***/ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/pre-made-templates.png":
/*!**************************************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/pre-made-templates.png ***!
  \**************************************************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/pre-made-templates.97ec2647.png";

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/edit-post":
/*!**********************************!*\
  !*** external ["wp","editPost"] ***!
  \**********************************/
/***/ ((module) => {

module.exports = window["wp"]["editPost"];

/***/ }),

/***/ "@wordpress/editor":
/*!********************************!*\
  !*** external ["wp","editor"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["editor"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["plugins"];

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

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
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		var scriptUrl;
/******/ 		if (__webpack_require__.g.importScripts) scriptUrl = __webpack_require__.g.location + "";
/******/ 		var document = __webpack_require__.g.document;
/******/ 		if (!scriptUrl && document) {
/******/ 			if (document.currentScript && document.currentScript.tagName.toUpperCase() === 'SCRIPT')
/******/ 				scriptUrl = document.currentScript.src;
/******/ 			if (!scriptUrl) {
/******/ 				var scripts = document.getElementsByTagName("script");
/******/ 				if(scripts.length) {
/******/ 					var i = scripts.length - 1;
/******/ 					while (i > -1 && (!scriptUrl || !/^http(s?):/.test(scriptUrl))) scriptUrl = scripts[i--].src;
/******/ 				}
/******/ 			}
/******/ 		}
/******/ 		// When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration
/******/ 		// or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.
/******/ 		if (!scriptUrl) throw new Error("Automatic publicPath is not supported in this browser");
/******/ 		scriptUrl = scriptUrl.replace(/^blob:/, "").replace(/#.*$/, "").replace(/\?.*$/, "").replace(/\/[^\/]+$/, "/");
/******/ 		__webpack_require__.p = scriptUrl;
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!*****************************************************************************************!*\
  !*** ./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/index.js ***!
  \*****************************************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/edit-post */ "@wordpress/edit-post");
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _images_how_to_use_png__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./images/how-to-use.png */ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/how-to-use.png");
/* harmony import */ var _images_pre_made_templates_png__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./images/pre-made-templates.png */ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/pre-made-templates.png");
/* harmony import */ var _images_build_from_scratch_png__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./images/build-from-scratch.png */ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/build-from-scratch.png");
/* harmony import */ var _images_customize_each_block_png__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./images/customize-each-block.png */ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/customize-each-block.png");
/* harmony import */ var _images_documentation_png__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./images/documentation.png */ "./inc/modules/receipt-layouts/source/admin/js/block-editor/welcome-guide/images/documentation.png");

/* global orderableReceiptWelcomeGuide*/

/**
 * External dependencies
 */








/**
 * Internal dependencies
 */





function Image({
  src
}) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("picture", {
    className: "edit-post-welcome-guide__image"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: src,
    alt: ""
  }));
}
function Content({
  title,
  body
}) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("h1", {
    className: "edit-post-welcome-guide__heading"
  }, title), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "edit-post-welcome-guide__text"
  }, body));
}
function WelcomeGuide({
  close
}) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Guide, {
    className: "edit-post-welcome-guide",
    onFinish: close,
    pages: [{
      image: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Image, {
        src: _images_how_to_use_png__WEBPACK_IMPORTED_MODULE_8__
      }),
      content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Content, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('How to Use Receipt Layouts!', 'orderable'),
        body: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Receipt Layouts allow you to create specific tickets/receipts to suit your business. Whether it’s a kitchen ticket, delivery driver note, or customer receipt, you can create and customize it here.', 'orderable')
      })
    }, {
      image: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Image, {
        src: _images_pre_made_templates_png__WEBPACK_IMPORTED_MODULE_9__
      }),
      content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Content, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Using Our Pre-Made Templates', 'orderable'),
        body: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Edit one of our pre-made templates by adding a pattern. Add a block, click Browse all, then Patterns, and you’ll see a list of pre-built templates you can customize.', 'orderable')
      })
    }, {
      image: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Image, {
        src: _images_build_from_scratch_png__WEBPACK_IMPORTED_MODULE_10__
      }),
      content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Content, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Build From Scratch', 'orderable'),
        body: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Alternatively, you can build your own custom layout from scratch. Add the blocks you want from the order total, the table number, and more.', 'orderable')
      })
    }, {
      image: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Image, {
        src: _images_customize_each_block_png__WEBPACK_IMPORTED_MODULE_11__
      }),
      content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Content, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Customize Each Block', 'orderable'),
        body: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Each block you add can be customized to suit you. You can change the label or hide it, adjust colors, padding, and more. Because this is the WordPress editor, you can add custom text anywhere in the layout.', 'orderable')
      })
    }, {
      image: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Image, {
        src: _images_documentation_png__WEBPACK_IMPORTED_MODULE_12__
      }),
      content: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(Content, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Learn More About Receipt Layouts', 'orderable'),
        body: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.createInterpolateElement)((0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)("Not quite sure where to start? We've got you covered! Check out our documentation to learn more about <a>Receipt Layouts</a>.", 'orderable'), {
          a:
          // eslint-disable-next-line jsx-a11y/anchor-has-content
          (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
            href: "https://orderable.com/docs/ticket-receipt-layouts/",
            target: "_blank",
            rel: "noreferrer"
          })
        })
      })
    }]
  });
}
function TutorialPanel() {
  const shouldShowWelcomeGuide = orderableReceiptWelcomeGuide?.shouldShowWelcomeGuide;
  const [isOpen, setIsOpen] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useState)(shouldShowWelcomeGuide);
  const {
    setIsInserterOpened
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.useDispatch)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_2__.store.name);
  const {
    openGeneralSidebar
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_7__.useDispatch)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_3__.store.name);
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_5__.useEffect)(() => {
    if (!shouldShowWelcomeGuide) {
      return;
    }
    setIsInserterOpened(true);
    setTimeout(() => {
      const patternTabElement = document.querySelector('.block-editor-tabbed-sidebar__tab[id*="-patterns"]');
      if (patternTabElement) {
        patternTabElement.click();
        const receiptPatternsElement = document.querySelector('[id*="orderable/receipt-layouts"]');
        receiptPatternsElement?.click();
        openGeneralSidebar('edit-post/document');
      }
    }, 350);
  }, [shouldShowWelcomeGuide]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_editor__WEBPACK_IMPORTED_MODULE_2__.PluginDocumentSettingPanel, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Tutorial', 'orderable'),
    name: "orderable-receipt-tutorial"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    variant: "secondary",
    onClick: () => setIsOpen(true)
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__.__)('Show Welcome Guide', 'orderable')), isOpen && (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(WelcomeGuide, {
    close: () => setIsOpen(false)
  }));
}
(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_1__.registerPlugin)('orderable-receipt-layout-tutorial', {
  render: TutorialPanel,
  icon: 'welcome-view-site'
});
})();

/******/ })()
;
//# sourceMappingURL=index.js.map