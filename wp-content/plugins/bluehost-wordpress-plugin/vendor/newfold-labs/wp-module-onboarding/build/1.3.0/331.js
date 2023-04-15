"use strict";(self.webpackChunknewfold_Onboarding=self.webpackChunknewfold_Onboarding||[]).push([[331],{4401:function(e,t,r){r.d(t,{V:function(){return l}});var a=r(9307),n=r(5791),o=r(4316),s=r(950),l=e=>{let{title:t,subtitle:r,error:l}=e;return(0,a.createElement)(n.Z,{className:"step-error-state",isVerticallyCentered:!0},(0,a.createElement)(o.Z,{title:t,subtitle:r}),(0,a.createElement)("div",{className:"step-error-state__logo"}),(0,a.createElement)("h3",{className:"step-error-state__error"},l),(0,a.createElement)(s.Z,null))}},4316:function(e,t,r){var a=r(9307),n=r(5736);t.Z=e=>{let{title:t,subtitle:r}=e;return(0,a.createElement)("div",{className:"nfd-main-heading"},(0,a.createElement)("h2",{className:"nfd-main-heading__title"},(0,n.__)(t,"wp-module-onboarding")),(0,a.createElement)("h3",{className:"nfd-main-heading__subtitle"},(0,n.__)(r,"wp-module-onboarding")))}},5791:function(e,t,r){r.d(t,{Z:function(){return w}});var a=r(9307),n=r(4184),o=r.n(n),s=r(5158),l=r(6974),i=r(2200),d=r(6989),u=r.n(d),c=r(4704),m=e=>{let{className:t="nfd-onboarding-layout__base",children:r}=e;const n=(0,l.TH)(),d=document.querySelector(".nfd-onboard-content");return(0,a.useEffect)((()=>{null==d||d.focus({preventScroll:!0}),function(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"Showing new Onboarding Page";(0,s.speak)(t,"assertive")}(n,"Override"),new class{constructor(e){let t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};this.eventSlug=e,this.eventData=t}send(){u()({url:(0,c.F)("events"),method:"POST",data:{slug:this.eventSlug,data:this.eventData}}).catch((e=>{console.error(e)}))}}(`${i.Db}-pageview`,{stepID:n.pathname,previousStepID:window.nfdOnboarding.previousStepID}).send(),window.nfdOnboarding.previousStepID=n.pathname}),[n.pathname]),(0,a.createElement)("div",{className:o()("nfd-onboarding-layout",t)},r)},h=r(682);const g=e=>{let{children:t}=e;return(0,a.createElement)("section",{className:"is-contained"},t)};var w=e=>{let{className:t="",children:r,isBgPrimary:n=!1,isCentered:s=!1,isVerticallyCentered:l=!1,isContained:i=!1,isPadded:d=!1,isFadeIn:u=!0}=e;const c=i?g:a.Fragment;return(0,a.createElement)(h.Z,{type:u&&"fade-in",duration:"233ms",timingFunction:"ease-in-out"},(0,a.createElement)(m,{className:o()("nfd-onboarding-layout__common",t,{"is-bg-primary":n},{"is-centered":s},{"is-vertically-centered":l},{"is-padded":d})},(0,a.createElement)(c,null,r)))}},7004:function(e,t,r){r.d(t,{L:function(){return d},Y:function(){return l}});var a=r(9307),n=r(5791),o=r(4316),s=r(950),l=e=>{let{title:t,subtitle:r}=e;return(0,a.createElement)(n.Z,{className:"step-loader",isVerticallyCentered:!0},(0,a.createElement)(o.Z,{title:t,subtitle:r}),(0,a.createElement)("div",{className:"step-loader__logo-container"},(0,a.createElement)("div",{className:"step-loader__logo"})),(0,a.createElement)(s.Z,null))},i=r(682),d=()=>(0,a.createElement)("div",{className:"image-upload-loader--loading-box"},(0,a.createElement)(i.Z,{type:"load",className:"image-upload-loader--loading-box__loader"}))},950:function(e,t,r){var a=r(9307),n=r(9685),o=r(9818),s=r(5736);t.Z=e=>{let{question:t=(0,s.__)("Need Help?","wp-module-onboarding"),urlLabel:r=(0,s.__)("Hire our Experts","wp-module-onboarding")}=e;const l=(0,o.select)(n.h).getHireExpertsUrl();return(0,a.createElement)("div",{className:"nfd-card-need-help-tag"},t,(0,a.createElement)("a",{href:l,target:"_blank"},r))}},1340:function(e,t,r){r.d(t,{U:function(){return h},g:function(){return p}});var a=r(9307),n=r(9818),o=r(4333),s=r(5736),l=r(7004),i=r(9685),d=r(7625),u=r(2200),c=r(4401),m=r(1589),h=e=>{let{children:t,navigationStateCallback:r=!1}=e;const h=(0,o.useViewportMatch)("medium"),{storedThemeStatus:g,brandName:w}=(0,n.useSelect)((e=>({storedThemeStatus:e(i.h).getThemeStatus(),brandName:e(i.h).getNewfoldBrandName()})),[]),p=(e=>({loader:{title:(0,s.sprintf)(
/* translators: %s: Brand */
(0,s.__)("Preparing your %s design studio","wp-module-onboarding"),e),subtitle:(0,s.__)("Hang tight while we show you some of the best WordPress has to offer!","wp-module-onboarding")},errorState:{title:(0,s.sprintf)(
/* translators: %s: Brand */
(0,s.__)("Preparing your %s design studio","wp-module-onboarding"),e),subtitle:(0,s.__)("Hang tight while we show you some of the best WordPress has to offer!","wp-module-onboarding"),error:(0,s.__)("Uh-oh, something went wrong. Please contact support.","wp-module-onboarding")}}))(w),{updateThemeStatus:b,setIsDrawerOpened:_,setIsDrawerSuppressed:f,setIsHeaderNavigationEnabled:v}=(0,n.useDispatch)(i.h),E=async()=>{const e=await(0,d.YL)(u.DY);return null!=e&&e.error?u.vv:e.body.status},y=()=>{switch(g){case u.Rq:case u.GV:return(()=>{if("function"==typeof r)return r();h&&_(!0),f(!1),v(!0)})();default:_(!1),f(!0),v(!1)}};(0,a.useEffect)((()=>{y(),g===u.a0&&(async()=>{const e=await E();switch(e){case u.Zh:setTimeout((async()=>{if(await E()!==u.GV)return b(u.vv);window.location.reload()}),u.YU);break;case u.GV:window.location.reload();break;default:b(e)}})()}),[g]);const S=async()=>(b(u.Zh),(await(0,d.N9)(u.DY,!0,!1)).error?b(u.Rq):window.location.reload());return(0,a.createElement)(a.Fragment,null,(()=>{switch(g){case u.vv:return(0,a.createElement)(m.Z,{showButton:!1,isModalOpen:!0,modalTitle:(0,s.__)("It looks like you may have an existing website","wp-module-onboarding"),modalText:(0,s.__)("Going through this setup will change your active theme, WordPress settings, add content – would you like to continue?","wp-module-onboarding"),modalOnClose:S,modalExitButtonText:(0,s.__)("Exit to WordPress","wp-module-onboarding")});case u.Rq:return(0,a.createElement)(c.V,{title:p.errorState.title,subtitle:p.errorState.subtitle,error:p.errorState.error});case u.GV:return t;default:return(0,a.createElement)(l.Y,{title:p.loader.title,subtitle:p.loader.subtitle})}})())},g=r(3421),w=r(1392),p=e=>{let{children:t,navigationStateCallback:r=!1}=e;const d=(0,o.useViewportMatch)("medium"),[m,h]=(0,a.useState)(u.Sr),{storedPluginsStatus:p,brandName:b}=(0,n.useSelect)((e=>({storedPluginsStatus:e(i.h).getPluginsStatus(),brandName:e(i.h).getNewfoldBrandName()})),[]),_=(e=>({loader:{title:(0,s.sprintf)(
/* translators: 1: Brand 2: Site */
(0,s.__)("Making the keys to your %s Online %s","wp-module-onboarding"),e,(0,w.I)("Site")),subtitle:(0,s.__)("We’re installing WooCommerce for you to fill with your amazing products & services!","wp-module-onboarding")},errorState:{title:(0,s.sprintf)(
/* translators: 1: Brand 2: Site */
(0,s.__)("Making the keys to your %s Online %s","wp-module-onboarding"),e,(0,w.I)("Site")),subtitle:(0,s.__)("We’re installing WooCommerce for you to fill with your amazing products & services!","wp-module-onboarding"),error:(0,s.__)("Uh-oh, something went wrong. Please contact support.","wp-module-onboarding")}}))(b),{updatePluginsStatus:f,setIsDrawerOpened:v,setIsDrawerSuppressed:E,setIsHeaderNavigationEnabled:y}=(0,n.useDispatch)(i.h),S=async()=>{const e=await(0,g.qC)(u.Gv);return null!=e&&e.error?u.sG:e.body.status},N=e=>{switch(e){case u.sG:case u.ye:return(()=>{if("function"==typeof r)return r();d&&v(!0),E(!1),y(!0)})();default:v(!1),E(!0),y(!1)}};(0,a.useEffect)((()=>{N(m)}),[m]);return(0,a.useEffect)((()=>{h(p[u.Gv]),p[u.Gv]===u.Ck&&(async e=>{const t=await S();switch(t){case u.Sr:setTimeout((async()=>{if(await S()!==u.ye)return p[u.Gv]=u.sG,f(p),h(u.sG);window.location.reload()}),u.sr);break;case u.ye:window.location.reload();break;default:e[u.Gv]=t,h(t),f(e)}})(p)}),[p]),(0,a.createElement)(a.Fragment,null,(()=>{switch(m){case u.sG:return(0,a.createElement)(c.V,{title:_.errorState.title,subtitle:_.errorState.subtitle,error:_.errorState.error});case u.ye:return t;default:return(0,a.createElement)(l.Y,{title:_.loader.title,subtitle:_.loader.subtitle})}})())}},5331:function(e,t,r){r.r(t);var a=r(9307),n=r(9818),o=r(5791),s=r(1340),l=r(6332),i=r(2200),d=r(9685);t.default=()=>{const{headerMenu:e}=(0,n.useSelect)((e=>({headerMenu:e(d.h).getHeaderMenuData()})),[]),[t,r]=(0,a.useState)(),{setDrawerActiveView:u,setSidebarActiveView:c}=(0,n.useDispatch)(d.h);return(0,a.useLayoutEffect)((()=>{r(e)}),[e]),(0,a.useEffect)((()=>{c(i.Jq),u(i.qO)}),[]),(0,a.createElement)(s.U,null,(0,a.createElement)(l.V3,null,(0,a.createElement)(o.Z,{className:"theme-header-menu-preview"},(0,a.createElement)("div",{className:"theme-header-menu-preview__title-bar"},(0,a.createElement)("div",{className:"theme-header-menu-preview__title-bar__browser"},(0,a.createElement)("span",{className:"theme-header-menu-preview__title-bar__browser__dot"}),(0,a.createElement)("span",{className:"theme-header-menu-preview__title-bar__browser__dot"}),(0,a.createElement)("span",{className:"theme-header-menu-preview__title-bar__browser__dot"}))),!t&&(0,a.createElement)(l.i5,{blockGrammer:"",styling:"large",viewportWidth:1300}),t&&(0,a.createElement)(l.i5,{blockGrammer:t,styling:"large",viewportWidth:1300}))))}}}]);