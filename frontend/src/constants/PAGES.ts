import { Page } from "../types/page"

const PAGES = {

  login: { 
    path: '/login',
    name: 'Login',
  } as Page,

  home: { 
    path: '/',
    name: 'Home',
  } as Page,

  accounts: { 
    path: '/accounts',
    name: 'Accounts',
  } as Page,

  spends: { 
    path: '/spends',
    name: 'Spends',
  } as Page,

  received: { 
    path: '/received',
    name: 'Received',
  } as Page,

  logout: { 
    path: '/logout',
    name: 'Logout',
  } as Page,
}

export default PAGES