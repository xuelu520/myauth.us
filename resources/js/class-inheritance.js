/**
 * Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 */(function(){var e=!1,t=/xyz/.test(function(){xyz})?/\b_super\b/:/.*/;window.Class=function(){},Class.extend=function(n){function o(){!e&&this.init&&this.init.apply(this,arguments)}var r=this.prototype;e=!0;var i=new this;e=!1;for(var s in n)typeof n[s]=="function"&&typeof r[s]=="function"&&t.test(n[s])?i[s]=function(e,t){return function(){var n=this._super;this._super=r[e];var i=t.apply(this,arguments);return this._super=n,i}}(s,n[s]):i[s]=n[s];return o.prototype=i,o.constructor=o,o.extend=this.callee||arguments.callee,o}})()