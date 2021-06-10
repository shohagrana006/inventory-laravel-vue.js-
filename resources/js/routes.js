// authentication
let login        = require('./components/auth/login.vue').default;
let register     = require('./components/auth/register.vue').default;
let forget       = require('./components/auth/forget.vue').default;
let logout       = require('./components/auth/logout.vue').default;

let home         = require('./components/home.vue').default;

// employment
let employee     = require('./components/employee/index.vue').default;
let addEmployee  = require('./components/employee/addemployee.vue').default;
let editEmployee = require('./components/employee/editemployee.vue').default;

// Supplier
let supplier     = require('./components/supplier/index.vue').default;
let addSupplier  = require('./components/supplier/create.vue').default;
let editSupplier = require('./components/supplier/edit.vue').default;

// category
let category     = require('./components/category/index.vue').default;
let addCategory  = require('./components/category/create.vue').default;
let editCategory = require('./components/category/edit.vue').default;

// Product
let product      = require('./components/product/index.vue').default;
let addProduct   = require('./components/product/create.vue').default;
let editProduct  = require('./components/product/edit.vue').default;

// expense
let expense      = require('./components/expense/index.vue').default;
let addExpense   = require('./components/expense/create.vue').default;
let editExpense  = require('./components/expense/edit.vue').default;
// customer
let customer     = require('./components/customer/index.vue').default;
let addCustomer  = require('./components/customer/create.vue').default;
let editCustomer = require('./components/customer/edit.vue').default;

// salary
let salary       = require('./components/salary/allemployee.vue').default;
let paySalary    = require('./components/salary/create.vue').default;
let allSalary    = require('./components/salary/index.vue').default;
let viewSalary   = require('./components/salary/view.vue').default;
let editSalary   = require('./components/salary/edit.vue').default;

// stock
let stock        = require('./components/product/stock.vue').default;
let editstock    = require('./components/product/editstock.vue').default;
// pos
let pos          = require('./components/pos/pointofsale.vue').default;

// order
let order        = require('./components/order/order.vue').default;
let orderview    = require('./components/order/orderview.vue').default;
let searchorder  = require('./components/order/searchorder.vue').default;




export const routes = [
  // authentication
  { path: '/',          component: login,    name: '/'},
  { path: '/register',  component: register, name: 'register' },
  { path: '/forget',    component: forget,   name: 'forget'},
  { path: '/logout',    component: logout,   name: 'logout'},

  // Home
  { path: '/home',      component: home,     name: 'home'},

  // employment
  { path: '/employee',          component: employee,     name: 'employee'},
  { path: '/add/employee',      component: addEmployee,  name: 'addemployee'},
  { path: '/edit/employee/:id', component: editEmployee, name: 'editemployee'},

  // Supplier
  { path: '/supplier',          component: supplier,     name: 'supplier'},
  { path: '/add/supplier',      component: addSupplier,  name: 'addsupplier'},
  { path: '/edit/supplier/:id', component: editSupplier, name: 'editsupplier'},

  // category
  { path: '/category',          component: category,     name: 'category'},
  { path: '/add/category',      component: addCategory,  name: 'addcategory'},
  { path: '/edit/category/:id', component: editCategory, name: 'editcategory'},

  // Product
  { path: '/product',          component: product,     name: 'product'},
  { path: '/add/product',      component: addProduct,  name: 'addproduct'},
  { path: '/edit/product/:id', component: editProduct, name: 'editproduct'},

  // Expense
  { path: '/expense',          component: expense,     name: 'expense'},
  { path: '/add/expense',      component: addExpense,  name: 'addexpense'},
  { path: '/edit/expense/:id', component: editExpense, name: 'editexpense'},

  // Salary
  { path: '/given/salary',     component: salary,      name: 'givensalary'},
  { path: '/pay/salary/:id',   component: paySalary,   name: 'paysalary'},
  { path: '/salary',           component: allSalary,   name: 'allsalary'},
  { path: '/view/salary/:id',  component: viewSalary,  name: 'viewsalary'},
  { path: '/edit/salary/:id',  component: editSalary,  name: 'editsalary'},

  // stock
  { path: '/stock',            component: stock,       name: 'stock'},
  { path: '/edit/stock/:id',   component: editstock,   name: 'editstock'},

  // Customer
  { path: '/customer',          component: customer,     name: 'customer'},
  { path: '/add/customer',      component: addCustomer,  name: 'addcustomer'},
  { path: '/edit/customer/:id', component: editCustomer, name: 'editcustomer'},

  // pos
  { path: '/pos',               component: pos,          name: 'pos'},

  // order
  { path: '/order',             component: order,        name: 'order'},
  { path: '/order/view',        component: orderview,    name: 'orderview'},
  { path: '/search/order',      component: searchorder,  name: 'searchorder'},


]