webpackJsonp([3,5],{13:function(e,o,t){"use strict";Object.defineProperty(o,"__esModule",{value:!0});var s=t(1);o["default"]={vuex:{actions:{login:s.login}},methods:{submit:function(){this.$http.post("/api/login",{username:this.username.trim(),password:this.password}).then(function(e){var o=new Date(e.data.expire);document.cookie="cookie="+e.data.cookie+";expires="+o.toGMTString(),this.login(e.data.user),this.$route.router.go(-1)}).then(function(e){console.log(e)})}},data:function(){return{username:"",password:""}}}},22:function(e,o){e.exports=' <div class="uk-container-center uk-width-medium-1-3 uk-width-small-1-2"> <h3 class="uk-text-center uk-margin-top">欢迎回来！</h3> <form class="uk-form uk-form-stacked uk-panel uk-panel-box" v-on:submit.prevent=submit> <div class="uk-alert uk-alert-danger" hidden=hidden></div> <div class=uk-form-row> <label class="uk-form-label uk-hidden-small">用户名:</label> <div class="uk-form-controls uk-form-icon"> <i class=uk-icon-envelope-o></i> <input class="uk-form-large uk-form-width-large" type=text placeholder=用户名 maxlength=50 v-model=username> </div> </div> <div class=uk-form-row> <label class="uk-form-label uk-hidden-small">输入密码:</label> <div class="uk-form-controls uk-form-icon"> <i class=uk-icon-lock></i> <input class="uk-form-large uk-form-width-large" type=password placeholder=输入密码 maxlength=50 v-model=password> </div> </div> <div class=uk-form-row> <button type=submit class="uk-width-1-1 uk-button uk-button-primary uk-button-large"><i class=uk-icon-sign-in></i> 登录</button> </div> </form> </div> '},30:function(e,o,t){var s,i;s=t(13),i=t(22),e.exports=s||{},e.exports.__esModule&&(e.exports=e.exports["default"]),i&&(("function"==typeof e.exports?e.exports.options||(e.exports.options={}):e.exports).template=i)}});
//# sourceMappingURL=3.67a4d89d1121912332bc.js.map