
require('./bootstrap');

window.Vue = require('vue').default;
import { BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import VueSession from 'vue-session'
import VueBarcode from 'vue-barcode'
import Vue2Editor from "vue2-editor";

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueHtmlToPaper from 'vue-html-to-paper';

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(Vue2Editor);

Vue.component('barcode', VueBarcode)

const sessionOption = {
  persist: true
};
Vue.use(VueSession, sessionOption)

const options = {
name: '_blank',
specs: [
  'fullscreen=yes',
  'titlebar=yes',
  'scrollbars=yes'
],

styles: [
  'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
],
timeout: 1000,
autoClose: true,
windowTitle: '',
};

Vue.use(VueHtmlToPaper, options);

// Home Controller
Vue.component('display', require('./components/web/display.vue').default);
Vue.component('home', require('./components/web/home.vue').default);
Vue.component('terms', require('./components/web/terms.vue').default);
Vue.component('courses', require('./components/web/courses.vue').default);
Vue.component('contactus', require('./components/web/contact.vue').default);
Vue.component('about', require('./components/web/about.vue').default);
Vue.component('aboutus', require('./components/web-components/aboutus.vue').default);
Vue.component('team', require('./components/web-components/team.vue').default);
Vue.component('banner', require('./components/web-components/banner.vue').default);
Vue.component('solution', require('./components/web-components/solution.vue').default);
Vue.component('joinus', require('./components/web-components/joinus.vue').default);
Vue.component('courses-slideshow', require('./components/web-components/courses-slideshow.vue').default);
Vue.component('essential-course', require('./components/web-components/essential-course.vue').default);
Vue.component('whatisnew', require('./components/web-components/whatisnew.vue').default);
Vue.component('web-footer', require('./components/web-components/footer_menu.vue').default);
Vue.component('tawkto', require('./components/support/tawkto.vue').default);

// includes 
Vue.component('auth-header', require('./components/layouts/auths/auth_header.vue').default);
Vue.component('menu-header', require('./components/layouts/web-headers/menu_header.vue').default);
Vue.component('menu-footer', require('./components/layouts/web-headers/menu_footer.vue').default);

Vue.component('header-backend-general', require('./components/layouts/backend-headers/header_backend_general.vue').default);
Vue.component('sidebar-backend-menu', require('./components/layouts/sidebars/sidebar_backend_menu.vue').default);
Vue.component('flyout-backend-menu', require('./components/layouts/backend-headers/flyout_profile.vue').default);
Vue.component('flyout-notification', require('./components/layouts/backend-headers/notification.vue').default);

// Signup Controller
Vue.component('signup-guide', require('./components/auths/signin.vue').default);
Vue.component('signup', require('./components/signup/newrecord.vue').default);
Vue.component('signup-verify', require('./components/auths/signin.vue').default);

// Dashboard Controller
Vue.component('dashboard', require('./components/dashboard/home.vue').default);

// Settings
Vue.component('manage-setting', require('./components/settings/manage.vue').default);
Vue.component('maintenance', require('./components/settings/maintenance.vue').default);

// Notification
Vue.component('server-alert', require('./components/alerts/server_alert.vue').default);
Vue.component('notification', require('./components/alerts/notification.vue').default);
Vue.component('error-alert', require('./components/alerts/errorAlert.vue').default);

// Auth Controller
Vue.component('signin', require('./components/auths/signin.vue').default);
Vue.component('logout', require('./components/auths/logout.vue').default);
Vue.component('forgot-password', require('./components/auths/forgot_password.vue').default);
Vue.component('change-password', require('./components/auths/change_password.vue').default);
Vue.component('authentication', require('./components/auths/authentication.vue').default);
Vue.component('authentication-failure', require('./components/auths/authenticationFailure.vue').default);


//User controller
Vue.component('upload_batch_user', require('./components/user/uploadbatch.vue').default);
Vue.component('create_user', require('./components/user/newrecord.vue').default);
Vue.component('user_profile', require('./components/user/profile.vue').default);
Vue.component('user_record', require('./components/user/record.vue').default);
Vue.component('manage_user', require('./components/user/manage.vue').default);
Vue.component('delete_user', require('./components/user/delete.vue').default);
Vue.component('edit_user_name', require('./components/user/edit_name.vue').default);
Vue.component('edit_user_dob', require('./components/user/edit_dob.vue').default);
Vue.component('edit_user_phone', require('./components/user/edit_phone.vue').default);
Vue.component('edit_user_contact_address', require('./components/user/edit_contact_address.vue').default);
Vue.component('edit_user_gender', require('./components/user/edit_gender.vue').default);
Vue.component('edit_user_password', require('./components/user/edit_password.vue').default);
Vue.component('user_passport', require('./components/user/passport.vue').default);

//Admin controller
Vue.component('upload_batch_admin', require('./components/admin/uploadbatch.vue').default);
Vue.component('create_admin', require('./components/admin/newrecord.vue').default);
Vue.component('admin_profile', require('./components/admin/profile.vue').default);
Vue.component('delete_admin', require('./components/admin/delete.vue').default);
Vue.component('admin_record', require('./components/admin/record.vue').default);
Vue.component('manage_admin', require('./components/admin/manage.vue').default);
Vue.component('edit_admin_name', require('./components/admin/edit_name.vue').default);
Vue.component('edit_admin_dob', require('./components/admin/edit_dob.vue').default);
Vue.component('edit_admin_phone', require('./components/admin/edit_phone.vue').default);
Vue.component('edit_admin_contact_address', require('./components/admin/edit_contact_address.vue').default);
Vue.component('edit_admin_gender', require('./components/admin/edit_gender.vue').default);
Vue.component('edit_admin_password', require('./components/admin/edit_password.vue').default);
Vue.component('admin_passport', require('./components/admin/passport.vue').default);

// Account controller
Vue.component('create_account', require('./components/account/newrecord.vue').default);
Vue.component('manage_account', require('./components/account/manage.vue').default);
Vue.component('account_profile', require('./components/account/profile.vue').default);
Vue.component('edit_account_name', require('./components/account/edit_name.vue').default);
Vue.component('edit_account_dob', require('./components/account/edit_dob.vue').default);
Vue.component('edit_account_phone', require('./components/account/edit_phone.vue').default);
Vue.component('edit_account_contact_address', require('./components/account/edit_contact_address.vue').default);
Vue.component('edit_account_gender', require('./components/account/edit_gender.vue').default);
Vue.component('edit_account_password', require('./components/account/edit_password.vue').default);
Vue.component('account_passport', require('./components/account/passport.vue').default);

//roles controller
Vue.component('role_record', require('./components/role/record.vue').default);
Vue.component('manage_role', require('./components/role/manage.vue').default);
Vue.component('delete_role', require('./components/role/delete.vue').default);
Vue.component('create_role', require('./components/role/newrecord.vue').default);
Vue.component('edit_role', require('./components/role/edit.vue').default);

//Access controller
Vue.component('upload_batch_access', require('./components/access/uploadbatch.vue').default);
Vue.component('access_record', require('./components/access/record.vue').default);
Vue.component('manage_access', require('./components/access/manage.vue').default);
Vue.component('delete_access', require('./components/access/delete.vue').default);
Vue.component('create_access', require('./components/access/newrecord.vue').default);
Vue.component('edit_access', require('./components/access/edit.vue').default);

// Admin Menu group
Vue.component('admin_menu_group_record', require('./components/admin_menu_group/record.vue').default);
Vue.component('manage_admin_menu_group', require('./components/admin_menu_group/manage.vue').default);
Vue.component('delete_admin_menu_group', require('./components/admin_menu_group/delete.vue').default);
Vue.component('create_admin_menu_group', require('./components/admin_menu_group/newrecord.vue').default);
Vue.component('edit_admin_menu_group', require('./components/admin_menu_group/edit.vue').default);

// Admin Menu
Vue.component('admin_menu_record', require('./components/admin_menu/record.vue').default);
Vue.component('manage_admin_menu', require('./components/admin_menu/manage.vue').default);
Vue.component('delete_admin_menu', require('./components/admin_menu/delete.vue').default);
Vue.component('create_admin_menu', require('./components/admin_menu/newrecord.vue').default);
Vue.component('edit_admin_menu', require('./components/admin_menu/edit.vue').default);

//Role permission controller
Vue.component('role_permissions', require('./components/role_permissions/record.vue').default);

// Charts component
Vue.component('user-chart', require('./components/charts/user_chart.vue').default);
Vue.component('admin-chart', require('./components/charts/admin_chart.vue').default);
Vue.component('sales-chart', require('./components/charts/sales_chart.vue').default);
Vue.component('sales-chart-daily', require('./components/charts/sales_daily_chart.vue').default);

//Sales Items controller
Vue.component('upload_batch_salesitems', require('./components/sales_items/uploadbatch.vue').default);
Vue.component('create_salesitems', require('./components/sales_items/newrecord.vue').default);
Vue.component('salesitems_record', require('./components/sales_items/record.vue').default);
Vue.component('edit_salesitems', require('./components/sales_items/edit.vue').default);
Vue.component('delete_salesitems', require('./components/sales_items/delete.vue').default);
Vue.component('manage_salesitems', require('./components/sales_items/manage.vue').default);

//Post_category controller
Vue.component('category_record_post', require('./components/post_category/record.vue').default);
Vue.component('create_post_category', require('./components/post_category/newrecord.vue').default);
Vue.component('edit-post-category', require('./components/post_category/edit.vue').default);


//Post controller
Vue.component('record_post', require('./components/posts/record.vue').default);
Vue.component('manage_post', require('./components/posts/manage.vue').default);
Vue.component('delete_post', require('./components/posts/delete.vue').default);
Vue.component('create_post', require('./components/posts/newrecord.vue').default);
Vue.component('edit_post', require('./components/posts/edit.vue').default);

//Media controller
Vue.component('media_record', require('./components/media/record.vue').default);
Vue.component('create_media', require('./components/media/newrecord.vue').default);
Vue.component('media_edit', require('./components/media/edit.vue').default);

//Course_category controller
Vue.component('category_course_record', require('./components/course_category/record.vue').default);
Vue.component('create_course_category', require('./components/course_category/newrecord.vue').default);
Vue.component('edit-course-category', require('./components/course_category/edit.vue').default);

//Course controller
Vue.component('record_course', require('./components/courses/record.vue').default);
Vue.component('create_course', require('./components/courses/newrecord.vue').default);
Vue.component('manage_course', require('./components/courses/manage.vue').default);
Vue.component('delete_course', require('./components/courses/delete.vue').default);
Vue.component('edit_course', require('./components/courses/edit.vue').default);

//Notification controller
Vue.component('notification-record', require('./components/notification/record.vue').default);
Vue.component('notification-create', require('./components/notification/newrecord.vue').default);
Vue.component('notification-edit', require('./components/notification/edit.vue').default);


//POS controller
Vue.component('pos', require('./components/pos/portal.vue').default);
Vue.component('printinvoice', require('./components/pos/printinvoice.vue').default);
Vue.component('pos_record', require('./components/pos/record.vue').default);


//POS2 controller
Vue.component('pos2', require('./components/pos2/portal.vue').default);
Vue.component('printinvoice2', require('./components/pos2/printinvoice.vue').default);
Vue.component('pos_record2', require('./components/pos2/record.vue').default);

Vue.component('no_access', require('./components/errors/no_access.vue').default);
Vue.component('page_not_found', require('./components/errors/pageNotFound.vue').default);



const app = new Vue({
    el: '#app',
});
